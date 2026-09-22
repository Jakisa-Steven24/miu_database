MIU STUDENT MANAGEMENT SYSTEM - PROFESSIONAL DASHBOARD

1. Install XAMPP.
2. Start Apache and MySQL.
3. Create/import the database named miu_student_database using the supplied MIU_Student_Database.sql file.
4. Copy the folder "miu_student_system" into:
   C:\xampp\htdocs\
5. Check db.php. It assumes:
   MySQL host: localhost
   User: root
   Password: empty
   Database: miu_student_database
6. Open:
   http://localhost/miu_student_system/

DATA ENTRY ORDER
Department -> Lecturer -> Course -> Student -> Enrollment
Fee Type -> Payment

DESIGN
The pages use one shared professional MIU-style dashboard:
- Navy university header
- MIU branding
- Left navigation sidebar
- Blue active menu item
- White cards with subtle borders/shadows
- Two-column responsive forms
- Mobile responsive layout
- Database-driven dropdowns

The form field names match the provided MySQL database schema.
