MIU DATABASE FORMS - PROFESSIONAL DASHBOARD

1. Install XAMPP.
2. Start Apache and MySQL.
3. Create/import the database named "miu" (as configured in db.php) using the supplied
   MIU_Student_Database.sql schema file.
4. Copy this folder into:
   C:\xampp\htdocs\
5. Check db.php. It currently assumes:
   MySQL host: localhost
   User: root
   Password: empty
   Database: miu
6. Open:
   http://localhost/miu_database/

DATA ENTRY ORDER
Department -> Lecturer -> Course -> Student -> Enrollment
Fee Type -> Payment

FEATURES
- One shared MIU-branded dashboard (green / red / gold colours from miu.ac.ug).
- Register forms for every table, with database-driven dropdowns.
- A records table under every form with View, Edit and Delete buttons:
    View   -> shows the saved record read-only (page.php?view=ID)
    Edit   -> loads the record into the form for updating (page.php?edit=ID)
    Delete -> removes the record via delete_page.php?id=ID (asks for confirmation,
              and reports a friendly error when other rows still reference it).
- save_*.php files handle both INSERT (new record) and UPDATE (editing record).
- Two-column responsive forms and a mobile friendly layout.

CODE LAYOUT
- db.php          : mysqli connection + loads functions.php
- functions.php   : shared helpers (h(), redirect_to(), flash_alert(), row_actions(), ...)
- header.php      : top bar + sidebar (shared by all pages)
- footer.php      : closing markup + footer line
- *_*.php pages   : one file per table; statements are one per line for easy debugging

The form field names match the provided MySQL database schema.
