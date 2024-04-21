#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>

#define oto D7    //slot  ô tô
#define xemay D1  //slot  xe máy


uint8_t pre_oto = 0;
uint8_t pre_xemay = 0;

/*
các bước sử dụng:
B1: bật xampp, nhập địa chỉ sau:       http://192.168.1.116/web_parking/install.php
B2: khi có thông báo Database created successfully và Table arena1 created successfully và Table arena2 created successfully
=> chạy địa chỉ sau để hiển thị giao diện:       http://192.168.1.116/web_parking/view.php 
B3: mở tab trình duyệt mới, nhập địa chỉ sau:    http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=esp_parking&table=arena1 để hiển thị bảng dữ liệu
B4: nạp code vào esp
B5: reload các tab để kiểm tra kết quả
(*)Nếu thay đổi kết nối internet nhớ check địa chỉ IP và PORT ; thay vào các chỗ tương ứng.
*/


/* Thông tin đăng nhập wifi */
const char *ssid = "Bao Tan";  //Nhập thông tin wifi
const char *password = "Khunglongxanh@";
HTTPClient http;  //Khai báo đối tượng của lớp HTTPClient
WiFiClient client;
// Địa chỉ Web/Máy chủ để đọc/ghi từ
const char *host = "192.168.1.116";


//=======================================================================
//                    Cài đặt cơ bản
//=======================================================================

void setup() {

  Serial.begin(115200);
  //Khai báo trạng thái các chân  tín hiệu

  pinMode(oto, INPUT);
  pinMode(xemay, INPUT);

  delay(1000);
  WiFi.mode(WIFI_OFF);  //Ngăn chặn sự cố kết nối lại (mất quá nhiều thời gian để kết nối)
  delay(1000);
  WiFi.mode(WIFI_STA);  //Dòng này ẩn việc xem ESP là điểm phát wifi

  WiFi.begin(ssid, password);  //Kết nối với bộ định tuyến WiFi của bạn
  Serial.println("");

  Serial.print("Connecting");
  // Chờ đợi kết nối
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  //Nếu kết nối thành công hiển thị địa chỉ IP trong cửa sổ Serial monitor
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //Địa chỉ IP được gán cho ESP của bạn
}

// //=======================================================================
// //                    Chương trình chính
// //=======================================================================
void loop() {

  String getData, Link;

  uint8_t slot1 = digitalRead(oto);  // gọi các biến đại diện cho trạng thái các vị trí cần kiểm tra
  uint8_t slot2 = digitalRead(xemay);
  //tín hiệu digital trả về giá trị 1 hoặc 0, việc của mình là kiểm tra xem bao giờ có sự thay đổi từ 1 sang 0 hoặc từ 0 sang 1, để tránh trùng lặp dữ liệu

  bool isChanged_oto = false;  // Để tránh trả về các kết quả liên tục và chỉ trả kết quả khi có sự thay đổi, sử dụng một biến trung gian để lưu trạng thái của sự thay đổi giá trị của biến slot.
  bool isChanged_xemay = false;

  //slot 1: nếu như biến slot1 có giá trị khác với pre_oto
  if (slot1 != pre_oto && (slot1 == HIGH || slot1 == LOW)) {
    pre_oto = slot1;
    isChanged_oto = true;  // Gán giá trị của biến isChanged_oto thành true khi giá trị của slot1 khác với pre_oto
  }
  //slot 2: nếu như biến slot2 có giá trị khác với pre_xemay
  if (slot2 != pre_xemay && (slot2 == HIGH || slot2 == LOW)) {
    pre_xemay = slot2;
    isChanged_xemay = true;  // Gán giá trị của biến isChanged_xemay thành true khi giá trị của slot2 khác với pre_xemay
  }

  if (isChanged_oto) {
    // gửi dữ liệu lên server
    getData = "?cParkArena=" + String(1) + "&cStatus=" + String(slot1);
    Link = "http://192.168.1.116/test_parking/getdemo.php" + getData;
    http.begin(client, Link);  //Chỉ định đích yêu cầu
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpCode = http.GET();  // Gửi yêu cầu
    String payload = http.getString();
    Serial.println(httpCode);  //In mã trả về HTTP
    Serial.println(payload);   //In tải trọng phản hồi yêu cầu
    http.end();                //Đóng kết nối
    isChanged_oto = false;     // Đặt lại thành false sau khi gửi dữ liệu
  }

  if (isChanged_xemay) {
    getData = "?cParkArena=" + String(2) + "&cStatus=" + String(slot2);
    Link = "http://192.168.1.116/test_parking/getdemo.php" + getData;
    http.begin(client, Link);  //Chỉ định đích yêu cầu
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    int httpCode = http.GET();  //Gửi yêu cầu
    String payload = http.getString();
    Serial.println(httpCode);  //In mã trả về HTTP
    Serial.println(payload);   //In tải trọng phản hồi yêu cầu
    http.end();                //Đóng kết nối
    isChanged_xemay = false;   // Đặt lại thành false sau khi gửi dữ liệu
  }

  delay(1000);  //GET Data sau mỗi 1 giây
  Serial.println(getData);
}
