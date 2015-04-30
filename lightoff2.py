#!/usr/bin/env python
import time
import RPi.GPIO as GPIO

LED = 23

GPIO.setmode(GPIO.BOARD)
GPIO.setup(LED, GPIO.OUT)
GPIO.output(LED, GPIO.LOW)
GPIO.output(LED,GPIO.LOW)
