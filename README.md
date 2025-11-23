# Certificate Management Dashboard (Admin & Client Portals)

A complete **Certificate Management System** built using **PHP + MySQL**, providing a secure workflow where admins can create certificate drafts, clients can approve/decline them, and final certificates are generated and sent automatically.

---

## 📄 Project Overview

This is a web-based dashboard that handles the entire lifecycle of certificate issuance:

- Certificate creation  
- Masked PDF preview  
- Client review (approve/decline)  
- Automatic email notifications  
- Final unmasked certificate delivery  

It ensures a **secure, auditable, and automated workflow** for handling official certificates.

---

## 🎯 Core Features

### 🔐 User Roles & Authentication
- **Admin Login** – Full management access  
- **Client Login** – Certificate review and decision  
- Secure login with PHP sessions (or JWT optional)  
- Role-based access control  

---

## 🛠️ Admin Dashboard Features
- Manage clients (name, email, unique client ID)
- Create certificate drafts
  - Fields: title, description, expiry date, custom text
  - Masked expiry date shown in the preview (e.g., `XX/XX/XXXX`)
- Submit draft certificates for client review
- View all certificate statuses:
  - Pending  
  - Approved  
  - Declined  
- Track full certificate history & logs

---

## 👤 Client Dashboard Features
- Receive notifications for new certificates
- View **masked PDF** preview
- Approve or decline the certificate
- Upon approval:
  - Automatically receives **final unmasked PDF** via email
- All actions stored in logs

---

## ✉️ Email Notifications (SMTP)
Email sent using **PHPMailer** or any SMTP provider.

Emails are triggered on:
1. **Draft submission** (masked PDF attached)
2. **Final approval** (unmasked PDF attached)

All email logs are stored in MySQL.

---

## 📄 PDF Generation
PDFs are generated automatically using:
- **TCPDF**
- **FPDF**
- **DOMPDF**

System supports:
- Masked preview certificates  
- Final unmasked certificates  

---

## 🗄️ Database Structure (MySQL)
The database stores:
- Admin & Client user details  
- Certificate metadata (drafts, approvals, timestamps)  
- Email logs  
- Status change logs  

---

## 🧰 Tech Stack

| Layer | Technology |
|-------|------------|
| Frontend | HTML5, CSS3, JavaScript, Bootstrap |
| Backend | PHP (Vanilla PHP or Laravel optional) |
| Database | MySQL |
| PDF Generator | TCPDF / FPDF / DOMPDF |
| Email Service | PHPMailer (SMTP) |
| Authentication | PHP Sessions or JWT |

---

## ✅ Final Deliverables
- Complete Admin & Client Portals  
- Certificate draft → review → approval workflow  
- Masked & Unmasked PDF generation  
- Email notification system  
- MySQL schema (users, certificates, logs)  
- Clean, well-documented PHP codebase  

---
