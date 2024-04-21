// LCD
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0X27, 16, 2);

// Servo
#include <Servo.h>
#define SERVO_PIN 9
Servo gServo;

int sensorOpen = 7;
int sensorClose = 4;
int number = 5;  // khai báo số lượng chỗ đỗ xe
int flag1 = 0;   // khai báo cờ báo 1
int flag2 = 0;   // khai báo cờ báo 2
int pre_open = 1;
int pre_close = 1;

void setup() {
  Serial.begin(9600);
  pinMode(sensorOpen, INPUT);
  pinMode(sensorClose, INPUT);
  gServo.attach(SERVO_PIN);
  lcd.init();
  lcd.backlight();
  lcd.clear();  // xóa trắng màn hình cho vui, thật ra để xem màn hình chết chỗ nào hay không
}

void loop() {
  lcd.setCursor(1, 0);
  lcd.print("Welcome to UTC");
  int temp1 = digitalRead(sensorClose);  // gán giá trị digital của cảm biến đóng cửa vào biến temp1
  int temp = digitalRead(sensorOpen);    // gán giá trị digital của cảm biến mở cửa vào biến temp
  // open door

  /* trường hợp mở cửa, khi mà temp và cờ báo 1 cùng có giá trị = 0;
    cờ báo 1 nhảy lên = 1 nhằm đánh dấu hành động có vật cản ở cảm biến mở cửa;
   kiểm tra giá trị của cờ báo 2, vì mặc định lúc này chưa có gì nên cờ báo 2 vẫn = 0;
   và nếu cờ báo 2 = 0 => cửa mở => servo quay góc 180 độ;
   số lượng xe sẽ trừ đi 1;
   khi số lượng xe = 0 thì màn hình báo đã đầy chỗ đỗ xe và servo vẫn ở giá trị 0 độ;
   */
  if (temp != pre_open){
      if (temp == 0 && flag1 == 0) {
        if (number > 0) {
          flag1 = 1;
          if (flag2 == 0) {
            gServo.write(90);
            number = number - 1;
          }
        } else {
          lcd.clear();
          lcd.setCursor(0, 1);
          lcd.print("Sorry, It's Full");
          delay(1500);
          lcd.clear();
          gServo.write(0);
        }
      }
      pre_open = temp;
    }

  // close door
  /* trường hợp đóng cửa, khi mà temp1 và cờ báo 2 cùng có giá trị = 0;
     cờ báo 2 nhảy lên = 1 nhằm đánh dấu hành động có vật cản ở cảm biến đóng cửa;
    kiểm tra giá trị của cờ báo 1, vì mặc định lúc này chưa có gì nên cờ báo 1 vẫn = 0;
    và nếu cờ báo 1 = 0 => cửa mở => servo quay góc 90 độ;
    số lượng xe sẽ cộng thêm 1;
    */
  if (temp1 != pre_close) {
    if (temp1 == 0 && flag2 == 0) {
      flag2 = 1;
      if (flag1 == 0) {
        gServo.write(90);
        number = number + 1;
        if (number > 5) {  // khi số lượng xe > 5 ( số lượng mặc định) thì luôn hạ số lượng xuống = 5( tránh thừa trên màn hình mà không có chỗ đỗ);
          number = 5;
        }
      }
    }
    pre_close = temp1;
  }

  /* khi cờ báo 1 và cờ báo 2 lúc này cùng bằng 1
    xe đã đi qua => thực hiện hành động đóng cửa lại và reset giá trị 2 cờ báo về = 0;
    việc sử dụng cờ báo giúp cho cửa có thể tự động đóng mà không cần sử dụng hàm delay()
    khắc phục được nhược điểm là nếu có xe đứng yên tại cửa thì cửa không tự động đóng lại
    */
  if (flag1 == 1 && flag2 == 1) {
    gServo.write(0);
    flag1 = 0, flag2 = 0;
  }


  lcd.setCursor(0, 1);
  lcd.print("So cho trong:");
  lcd.setCursor(14, 1);
  lcd.print(number);  // in số lượng chỗ đỗ xe ra màn hình sau khi chạy các chương trình phía trên
}