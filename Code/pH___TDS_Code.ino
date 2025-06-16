#define TDS_PIN 33  // Use ADC1 pins: GPIO 32-39

void setup() {
  Serial.begin(9600);
}

void loop() {
  int analogValue = analogRead(TDS_PIN);  // Range: 0 to 4095
  float voltage = (analogValue / 4095.0) * 3.3;  // Convert to voltage (V)

  Serial.print("Analog Value: ");
  Serial.print(analogValue);
  Serial.print("  Voltage: ");
  Serial.println(voltage, 3);  // Print voltage with 3 decimal places

  delay(1000);  // Read every second
}
