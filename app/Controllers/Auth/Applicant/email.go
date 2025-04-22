package main

import (
	"fmt"
	"net/smtp"
	"os"
)

func sendOTPEmail(toEmail, otpCode string) error {
	from := "loudikmarkai@gmail.com"
	password := "aufd iudg ksjf rlki " // Use Gmail App Password

	smtpHost := "smtp.gmail.com"
	smtpPort := "587"

	subject := "Subject: Your OTP Code for Verification\n"
	body := fmt.Sprintf(`
Hello,

Your One-Time Password (OTP) for verification is:

	%s

Please enter this code within the next 5 minutes to continue.

If you did not request this, please ignore this email.

Thank you,
Support Team
`, otpCode)

	message := []byte(subject + "\n" + body)
	auth := smtp.PlainAuth("", from, password, smtpHost)

	to := []string{toEmail}
	err := smtp.SendMail(smtpHost+":"+smtpPort, auth, from, to, message)
	if err != nil {
		return err
	}

	return nil
}

func main() {
	if len(os.Args) < 3 {
		fmt.Println("Usage: go run main.go <OTP_CODE>")
		return
	}

	otp := os.Args[1]
	toEmail := os.Args[2]

	err := sendOTPEmail(toEmail, otp)
	if err != nil {
		fmt.Println("Failed to send OTP email:", err)
	} else {
		fmt.Println("OTP email sent successfully.")
	}
}
