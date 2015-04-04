def servo_slidercontrol(degrees):
	RPIO.setmode(RPIO.BCM)
	pwm_pin = 18
	#default sub-cycle=20ms, pulse-width increment resolution=10us
	servo = PWM.Servo()

	#0 deg = 900us
	#90 deg(neutral) = 1500us
	#180 deg = 2100us
	#(2100-900)/(180) = ~6.5us/deg
	#delta_ms= degrees*6.5us/deg
	#pulse_duration = absolute position in useconds
	#Move to position indicated by slider
	print 'position %d' % (degrees)
	delta_ms = degrees*6.5
	pulse_duration = 900+delta_ms
	print 'new pulse-width=%f' % (pulse_duration)
	servo.set_servo(pwm_pin,pulse_duration)
	time.sleep(1)  # wait for 10-seconds
	#Clear servo on GPIO18
	servo.stop_servo(pwm_pin)

if __name__=="__main__":
	import sys
	import time
	import RPIO
	from RPIO import PWM

	servo_slidercontrol(int(sys.argv[1]))
