🔧 كيفية تشغيل المشروع:

1️⃣ تثبيت XAMPP:
   - حمل XAMPP من: https://www.apachefriends.org
   - شغّل Apache و MySQL.

2️⃣ إعداد backend:
   - انسخ مجلد "backend" إلى:
     C:\xampp\htdocs\backend

3️⃣ إعداد قاعدة البيانات:
   - افتح phpMyAdmin: http://localhost/phpmyadmin
   - أنشئ قاعدة بيانات جديدة.
   - استورد ملف SQL الموجود في مجلد backend/sql (إن وُجد).
   - عدّل معلومات الاتصال في:
     backend/config/db.php

4️⃣ تشغيل frontend:
   - افتح مجلد frontend في VS Code.
   - نفّذ:
     npm install
     npm run dev

5️⃣ اختبار النظام:
   - افتح المتصفح:
     http://localhost:5173
   - سجّل الدخول حسب الدور (admin أو technician أو client).

6️⃣ Vérification téléphone (SMS + WhatsApp via Twilio):
   - Créez le fichier config/twilio_config.php à partir de config/twilio_config.example.php
   - Renseignez account_sid, auth_token, from_sms (numéro Twilio), from_whatsapp (ex: whatsapp:+14155238886 pour le sandbox)
   - Assurez-vous que la table contracts a les colonnes verification_code et verified (voir sql/contracts_verification_columns.sql)
   - À la création d'un client, le code est envoyé par SMS et WhatsApp via Twilio.
