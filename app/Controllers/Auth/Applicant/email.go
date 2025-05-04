package main

import (
	"fmt"
	"net/smtp"
	"strings"

	"github.com/gofiber/fiber/v2"
)

const (
	authToken = "Bearer BearerMySecretToken123" // Ganti dengan token yang lebih aman
	smtpHost  = "smtp.gmail.com"
	smtpPort  = "587"
	from      = "loudikmarkai@gmail.com"
	password  = "aufd iudg ksjf rlki" // Gunakan App Password Gmail
)

func sendOTPEmail(toEmail, otpCode string) error {
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

	return smtp.SendMail(smtpHost+":"+smtpPort, auth, from, to, message)
}

func main() {
	app := fiber.New()

	app.Get("/send-otp", func(c *fiber.Ctx) error {

		// Auth check
		authHeader := c.Get("Authorization")
		if !strings.HasPrefix(authHeader, "Bearer ") || authHeader != authToken {
			return c.Status(fiber.StatusUnauthorized).JSON(fiber.Map{
				"status":  "error",
				"message": "Unauthorized",
			})
		}

		email := c.Query("email")
		otp := c.Query("otp")

		if email == "" || otp == "" {
			return c.Status(fiber.StatusBadRequest).JSON(fiber.Map{
				"status":  "error",
				"message": "Email and OTP are required",
			})
		}

		err := sendOTPEmail(email, otp)
		if err != nil {
			return c.Status(fiber.StatusInternalServerError).JSON(fiber.Map{
				"status":  "error",
				"message": "Failed to send email",
				"error":   err.Error(),
			})
		}

		return c.JSON(fiber.Map{
			"status":  "success",
			"message": "OTP email sent",
		})
	})

	// Run on port 9999
	app.Listen(":9999")
}
