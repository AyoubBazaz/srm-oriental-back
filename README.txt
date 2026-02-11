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
