#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>

#define vitri_1 D0 // slot  ô tô 1/ vị trí 1
#define vitri_2 D1 // slot  ô tô 2/ vị trí 2
#define vitri_3 D2 // slot  ô tô 3/ vị trí 3
#define vitri_4 D3 // slot  xe máy 1/ vị trí 4
#define vitri_5 D4 // slot  xe máy 2/ vị trí 5

uint8_t pre_vt1 = 1;
uint8_t pre_vt2 = 1;
uint8_t pre_vt3 = 1;
uint8_t pre_vt4 = 1;
uint8_t pre_vt5 = 1;

/*
các bước sử dụng:
B1: bật xampp, nhập địa chỉ sau:       http://192.168.43.212/mainEspParking/install.php
B2: khi có thông báo Database created successfully và Table arena created successfully
=> chạy địa chỉ sau để hiển thị giao diện:       http://192.168.43.212/mainEspParking/view.php
B3: mở tab trình duyệt mới, nhập địa chỉ sau:    http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=mainEspParking&table=arena để hiển thị bảng dữ liệu
B4: nạp code vào esp
B5: reload các tab để kiểm tra kết quả
(*)Nếu thay đổi kết nối internet nhớ check địa chỉ IP và PORT ; thay vào các chỗ tương ứng.
*/

/* Thông tin đăng nhập wifi */
const char *ssid = "Checking Data Viettel"; // Nhập thông tin wifi
const char *password = "987654321@";
HTTPClient http; // Khai báo đối tượng của lớp HTTPClient
WiFiClient client;
// Địa chỉ Web/Máy chủ để đọc/ghi từ địa chỉ
const char *host = "192.168.43.212";

//=======================================================================
//                    Cài đặt cơ bản
//=======================================================================

void setup()
{

    Serial.begin(9600);
    // Khai báo trạng thái các chân  tín hiệu

    pinMode(vitri_1, INPUT);
    pinMode(vitri_2, INPUT);
    pinMode(vitri_3, INPUT);
    pinMode(vitri_4, INPUT);
    pinMode(vitri_5, INPUT);

    delay(1000);
    WiFi.mode(WIFI_OFF); // Ngăn chặn sự cố kết nối lại (mất quá nhiều thời gian để kết nối)
    delay(1000);
    WiFi.mode(WIFI_STA); // Dòng này ẩn việc xem ESP là điểm phát wifi

    WiFi.begin(ssid, password); // Kết nối với bộ định tuyến WiFi của bạn
    Serial.println("");

    Serial.print("Connecting");
    // Chờ đợi kết nối
    while (WiFi.status() != WL_CONNECTED)
    {
        delay(500);
        Serial.print(".");
    }
    // Nếu kết nối thành công hiển thị địa chỉ IP trong cửa sổ Serial monitor
    Serial.println("");
    Serial.print("Connected to ");
    Serial.println(ssid);
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP()); // Địa chỉ IP được gán cho ESP của bạn
}

// //=======================================================================
// //                    Chương trình chính
// //=======================================================================
void loop()
{

    String getData, Link;

    uint8_t slot1 = digitalRead(vitri_1); // gọi các biến đại diện cho trạng thái các vị trí cần kiểm tra
    uint8_t slot2 = digitalRead(vitri_2);
    uint8_t slot3 = digitalRead(vitri_3);
    uint8_t slot4 = digitalRead(vitri_4);
    uint8_t slot5 = digitalRead(vitri_5);

    // tín hiệu digital trả về giá trị 1 hoặc 0, việc của mình là kiểm tra xem bao giờ có sự thay đổi từ 1 sang 0 hoặc từ 0 sang 1, để tránh trùng lặp dữ liệu

    bool isChanged_slot1 = false; // Để tránh trả về các kết quả liên tục và chỉ trả kết quả khi có sự thay đổi, sử dụng một biến trung gian để lưu trạng thái của sự thay đổi giá trị của biến slot.
    bool isChanged_slot2 = false;
    bool isChanged_slot3 = false;
    bool isChanged_slot4 = false;
    bool isChanged_slot5 = false;

    // slot 1: nếu như biến slot1 có giá trị khác với pre_vt1
    if (slot1 != pre_vt1 && (slot1 == HIGH || slot1 == LOW))
    {
        pre_vt1 = slot1;
        isChanged_slot1 = true; // Gán giá trị của biến isChanged_slot1 thành true khi giá trị của slot1 khác với pre_vt1
    }
    // slot 2: nếu như biến slot2 có giá trị khác với pre_vt2
    if (slot2 != pre_vt2 && (slot2 == HIGH || slot2 == LOW))
    {
        pre_vt2 = slot2;
        isChanged_slot2 = true; // Gán giá trị của biến isChanged_slot2 thành true khi giá trị của slot2 khác với pre_vt2
    }

    // slot 3: nếu như biến slot1 có giá trị khác với pre_vt1
    if (slot3 != pre_vt3 && (slot3 == HIGH || slot3 == LOW))
    {
        pre_vt3 = slot3;
        isChanged_slot3 = true; // Gán giá trị của biến isChanged_slot3 thành true khi giá trị của slot3 khác với pre_vt3
    }

    // slot 4: nếu như biến slot4 có giá trị khác với pre_vt4
    if (slot4 != pre_vt4 && (slot4 == HIGH || slot4 == LOW))
    {
        pre_vt4 = slot4;
        isChanged_slot4 = true; // Gán giá trị của biến isChanged_slot4 thành true khi giá trị của slot4 khác với pre_vt4
    }
    // slot 5: nếu như biến slot5 có giá trị khác với pre_vt5
    if (slot5 != pre_vt5 && (slot5 == HIGH || slot5 == LOW))
    {
        pre_vt5 = slot5;
        isChanged_slot5 = true; // Gán giá trị của biến isChanged_slot5 thành true khi giá trị của slot5 khác với pre_vt5
    }

    if (isChanged_slot1)
    {
        // gửi dữ liệu lên server
        getData = "?vitri=" + String(1) + "&trangthai=" + String(slot1);
        Link = "http://192.168.43.212/mainEspParking/getdemo.php" + getData;
        http.begin(client, Link); // Chỉ định đích yêu cầu
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        int httpCode = http.GET(); // Gửi yêu cầu
        String payload = http.getString();
        Serial.println(httpCode); // In mã trả về HTTP
        Serial.println(payload);  // In tải trọng phản hồi yêu cầu
        http.end();               // Đóng kết nối 
        isChanged_slot1 = false;  // Đặt lại thành false sau khi gửi dữ liệu
    }

    if (isChanged_slot2)
    {
        // gửi dữ liệu lên server
        getData = "?vitri=" + String(2) + "&trangthai=" + String(slot2);
        Link = "http://192.168.43.212/mainEspParking/getdemo.php" + getData;
        http.begin(client, Link); // Chỉ định đích yêu cầu
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        int httpCode = http.GET(); // Gửi yêu cầu
        String payload = http.getString();
        Serial.println(httpCode); // In mã trả về HTTP
        Serial.println(payload);  // In tải trọng phản hồi yêu cầu
        http.end();               // Đóng kết nối
        isChanged_slot2 = false;  // Đặt lại thành false sau khi gửi dữ liệu
    }

    if (isChanged_slot3)
    {
        // gửi dữ liệu lên server
        getData = "?vitri=" + String(3) + "&trangthai=" + String(slot3);
        Link = "http://192.168.43.212/mainEspParking/getdemo.php" + getData;
        http.begin(client, Link); // Chỉ định đích yêu cầu
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        int httpCode = http.GET(); // Gửi yêu cầu
        String payload = http.getString();
        Serial.println(httpCode); // In mã trả về HTTP
        Serial.println(payload);  // In tải trọng phản hồi yêu cầu
        http.end();               // Đóng kết nối
        isChanged_slot3 = false;  // Đặt lại thành false sau khi gửi dữ liệu
    }

    if (isChanged_slot4)
    {
        // gửi dữ liệu lên server
        getData = "?vitri=" + String(4) + "&trangthai=" + String(slot4);
        Link = "http://192.168.43.212/mainEspParking/getdemo.php" + getData;
        http.begin(client, Link); // Chỉ định đích yêu cầu
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        int httpCode = http.GET(); // Gửi yêu cầu
        String payload = http.getString();
        Serial.println(httpCode); // In mã trả về HTTP
        Serial.println(payload);  // In tải trọng phản hồi yêu cầu
        http.end();               // Đóng kết nối
        isChanged_slot4 = false;  // Đặt lại thành false sau khi gửi dữ liệu
    }

    if (isChanged_slot5)
    {
        // gửi dữ liệu lên server
        getData = "?vitri=" + String(5) + "&trangthai=" + String(slot5);
        Link = "http://192.168.43.212/mainEspParking/getdemo.php" + getData;
        http.begin(client, Link); // Chỉ định đích yêu cầu
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        int httpCode = http.GET(); // Gửi yêu cầu
        String payload = http.getString();
        Serial.println(httpCode); // In mã trả về HTTP
        Serial.println(payload);  // In tải trọng phản hồi yêu cầu
        http.end();               // Đóng kết nối
        isChanged_slot5 = false;  // Đặt lại thành false sau khi gửi dữ liệu
    }

    delay(1000); // GET Data sau mỗi 1 giây
    Serial.println(getData);
}

