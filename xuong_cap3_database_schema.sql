-- ============================================================
--  XƯỞNG CẤP 3 — HỆ THỐNG QUẢN LÝ
--  Database Schema (MySQL 8.0+ / MariaDB 10.6+)
--  Phiên bản: 1.0  |  Ngày: 2025
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
--  MODULE HỆ THỐNG
-- ============================================================

CREATE TABLE departments (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code          VARCHAR(20) NOT NULL UNIQUE COMMENT 'Mã bộ môn, vd: BM_DT',
    name          VARCHAR(100) NOT NULL COMMENT 'Tên bộ môn',
    head_id       INT UNSIGNED NULL COMMENT 'Trưởng bộ môn (FK -> users)',
    description   TEXT NULL,
    is_active     TINYINT(1) NOT NULL DEFAULT 1,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Bộ môn trong trường';

CREATE TABLE users (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    -- role          ENUM('superadmin','admin','manager','staff') NOT NULL DEFAULT 'staff',
    -- department_id INT UNSIGNED NULL,
    avatar_url    VARCHAR(500) NULL,
    is_active     TINYINT(1) NOT NULL DEFAULT 1,
    last_login_at TIMESTAMP NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Tài khoản người dùng hệ thống';

-- Sau khi tạo bảng users, thêm FK cho departments.head_id
ALTER TABLE departments
    ADD CONSTRAINT fk_dept_head
    FOREIGN KEY (head_id) REFERENCES users(id) ON DELETE SET NULL;

CREATE TABLE audit_logs (
    id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id       INT UNSIGNED NULL,
    action        VARCHAR(100) NOT NULL COMMENT 'create|update|delete|login',
    table_name    VARCHAR(100) NOT NULL,
    record_id     INT UNSIGNED NULL,
    old_data      JSON NULL,
    new_data      JSON NULL,
    ip_address    VARCHAR(45) NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Nhật ký thao tác hệ thống';

-- ============================================================
--  MODULE CRM — KHÁCH HÀNG
-- ============================================================

CREATE TABLE customers (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code                VARCHAR(20) NOT NULL UNIQUE COMMENT 'Mã KH, vd: KH001',
    name                VARCHAR(200) NOT NULL COMMENT 'Tên khách hàng / tổ chức',
    type                ENUM('company','school','government','individual') NOT NULL DEFAULT 'company',
    address             TEXT NULL,
    province            VARCHAR(100) NULL,
    tax_code            VARCHAR(20) NULL COMMENT 'Mã số thuế',
    website             VARCHAR(300) NULL,
    email               VARCHAR(150) NULL,
    phone               VARCHAR(20) NULL,
    fax                 VARCHAR(20) NULL,
    department_id       INT UNSIGNED NULL COMMENT 'Bộ môn phụ trách',
    account_manager_id  INT UNSIGNED NULL COMMENT 'Nhân viên phụ trách',
    source              VARCHAR(100) NULL COMMENT 'Nguồn tiếp cận: giới thiệu, đấu thầu...',
    status              ENUM('active','potential','inactive') NOT NULL DEFAULT 'potential',
    notes               TEXT NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id)      REFERENCES departments(id) ON DELETE SET NULL,
    FOREIGN KEY (account_manager_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_type   (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Danh sách khách hàng';

CREATE TABLE contacts (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id   INT UNSIGNED NOT NULL,
    name          VARCHAR(100) NOT NULL COMMENT 'Họ tên người liên hệ',
    position      VARCHAR(100) NULL COMMENT 'Chức vụ',
    department    VARCHAR(100) NULL COMMENT 'Phòng ban bên khách hàng',
    phone         VARCHAR(20) NULL,
    mobile        VARCHAR(20) NULL,
    email         VARCHAR(150) NULL,
    is_primary    TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Người liên hệ chính',
    notes         TEXT NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    INDEX idx_customer (customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Người liên hệ của khách hàng';

-- ============================================================
--  MODULE CRM — HỢP ĐỒNG
-- ============================================================

CREATE TABLE contracts (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code            VARCHAR(30) NOT NULL UNIQUE COMMENT 'Số hợp đồng, vd: HĐ-2025-041',
    customer_id     INT UNSIGNED NOT NULL,
    department_id   INT UNSIGNED NULL COMMENT 'Bộ môn thực hiện',
    title           VARCHAR(300) NOT NULL COMMENT 'Tên/nội dung hợp đồng',
    description     TEXT NULL,
    value           DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Giá trị hợp đồng (VND)',
    vat_rate        DECIMAL(5,2) NOT NULL DEFAULT 10.00 COMMENT 'Thuế VAT (%)',
    vat_amount      DECIMAL(18,2) NOT NULL DEFAULT 0,
    total_value     DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Giá trị sau thuế',
    start_date      DATE NULL,
    end_date        DATE NULL,
    signed_date     DATE NULL,
    status          ENUM('draft','active','completed','overdue','cancelled') NOT NULL DEFAULT 'draft',
    payment_terms   TEXT NULL COMMENT 'Điều khoản thanh toán',
    warranty_months TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Bảo hành (tháng)',
    file_url        VARCHAR(500) NULL COMMENT 'File hợp đồng đính kèm',
    created_by      INT UNSIGNED NULL,
    updated_by      INT UNSIGNED NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id)   REFERENCES customers(id),
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by)    REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_customer  (customer_id),
    INDEX idx_status    (status),
    INDEX idx_end_date  (end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Hợp đồng';

CREATE TABLE contract_items (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contract_id   INT UNSIGNED NOT NULL,
    item_order    TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Thứ tự hạng mục',
    description   TEXT NOT NULL COMMENT 'Mô tả hạng mục công việc',
    unit          VARCHAR(30) NULL COMMENT 'Đơn vị: m, cái, bộ, gói...',
    quantity      DECIMAL(10,2) NOT NULL DEFAULT 1,
    unit_price    DECIMAL(18,2) NOT NULL DEFAULT 0,
    amount        DECIMAL(18,2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
    notes         TEXT NULL,
    FOREIGN KEY (contract_id) REFERENCES contracts(id) ON DELETE CASCADE,
    INDEX idx_contract (contract_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Hạng mục trong hợp đồng';

-- ============================================================
--  MODULE CRM — CHĂM SÓC KHÁCH HÀNG
-- ============================================================

CREATE TABLE customer_notes (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id   INT UNSIGNED NOT NULL,
    user_id       INT UNSIGNED NOT NULL,
    type          ENUM('call','email','meeting','visit','reminder','other') NOT NULL DEFAULT 'other',
    title         VARCHAR(200) NULL,
    content       TEXT NOT NULL,
    note_date     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    follow_up_date DATE NULL COMMENT 'Ngày cần theo dõi tiếp',
    is_pinned     TINYINT(1) NOT NULL DEFAULT 0,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id)     REFERENCES users(id),
    INDEX idx_customer  (customer_id),
    INDEX idx_note_date (note_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Lịch sử chăm sóc khách hàng';

CREATE TABLE tasks (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id   INT UNSIGNED NULL,
    contract_id   INT UNSIGNED NULL,
    assignee_id   INT UNSIGNED NULL COMMENT 'Người phụ trách',
    creator_id    INT UNSIGNED NULL,
    title         VARCHAR(300) NOT NULL,
    description   TEXT NULL,
    due_date      DATE NULL,
    priority      ENUM('high','medium','low') NOT NULL DEFAULT 'medium',
    status        ENUM('todo','in_progress','done','cancelled') NOT NULL DEFAULT 'todo',
    completed_at  DATETIME NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id)  REFERENCES customers(id) ON DELETE SET NULL,
    FOREIGN KEY (contract_id)  REFERENCES contracts(id) ON DELETE SET NULL,
    FOREIGN KEY (assignee_id)  REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (creator_id)   REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_assignee (assignee_id),
    INDEX idx_status   (status),
    INDEX idx_due_date (due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Công việc cần làm / nhắc nhở';

-- ============================================================
--  MODULE TÀI CHÍNH — HÓA ĐƠN
-- ============================================================

CREATE TABLE invoices (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code            VARCHAR(30) NOT NULL UNIQUE COMMENT 'Số hóa đơn, vd: HD-2025-089',
    contract_id     INT UNSIGNED NOT NULL,
    customer_id     INT UNSIGNED NOT NULL,
    department_id   INT UNSIGNED NULL,
    issue_date      DATE NOT NULL,
    due_date        DATE NOT NULL COMMENT 'Hạn thanh toán',
    subtotal        DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Tiền trước thuế',
    vat_rate        DECIMAL(5,2) NOT NULL DEFAULT 10.00,
    vat_amount      DECIMAL(18,2) NOT NULL DEFAULT 0,
    total_amount    DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Tổng tiền sau thuế',
    paid_amount     DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Đã thanh toán',
    remaining       DECIMAL(18,2) GENERATED ALWAYS AS (total_amount - paid_amount) STORED,
    status          ENUM('draft','sent','paid','partial','overdue','cancelled') NOT NULL DEFAULT 'draft',
    payment_method  ENUM('bank_transfer','cash','check','other') NULL,
    bank_info       TEXT NULL COMMENT 'Thông tin tài khoản nhận',
    notes           TEXT NULL,
    created_by      INT UNSIGNED NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (contract_id)   REFERENCES contracts(id),
    FOREIGN KEY (customer_id)   REFERENCES customers(id),
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by)    REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_customer (customer_id),
    INDEX idx_contract (contract_id),
    INDEX idx_status   (status),
    INDEX idx_due_date (due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Hóa đơn xuất cho khách hàng';

CREATE TABLE invoice_items (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    invoice_id    INT UNSIGNED NOT NULL,
    item_order    TINYINT UNSIGNED NOT NULL DEFAULT 1,
    description   TEXT NOT NULL,
    unit          VARCHAR(30) NULL,
    quantity      DECIMAL(10,2) NOT NULL DEFAULT 1,
    unit_price    DECIMAL(18,2) NOT NULL DEFAULT 0,
    amount        DECIMAL(18,2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
    vat_rate      DECIMAL(5,2) NOT NULL DEFAULT 10.00,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Chi tiết hóa đơn';

CREATE TABLE payments (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    invoice_id    INT UNSIGNED NOT NULL,
    amount        DECIMAL(18,2) NOT NULL,
    payment_date  DATE NOT NULL,
    method        ENUM('bank_transfer','cash','check','other') NOT NULL DEFAULT 'bank_transfer',
    reference     VARCHAR(100) NULL COMMENT 'Số tham chiếu / mã giao dịch',
    notes         TEXT NULL,
    attachment    VARCHAR(500) NULL COMMENT 'File chứng từ',
    recorded_by   INT UNSIGNED NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id)  REFERENCES invoices(id),
    FOREIGN KEY (recorded_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_invoice (invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Ghi nhận thanh toán hóa đơn';

-- ============================================================
--  MODULE TÀI CHÍNH — THU CHI
-- ============================================================

CREATE TABLE transaction_categories (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code        VARCHAR(20) NOT NULL UNIQUE,
    name        VARCHAR(100) NOT NULL,
    type        ENUM('income','expense') NOT NULL,
    parent_id   INT UNSIGNED NULL COMMENT 'Danh mục cha (phân cấp)',
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (parent_id) REFERENCES transaction_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Danh mục phân loại thu chi';

-- Dữ liệu mẫu danh mục
INSERT INTO transaction_categories (code, name, type, parent_id) VALUES
('TN',    'Thu',                     'income',  NULL),
('TN-HĐ', 'Thu từ hợp đồng',        'income',  1),
('TN-KH', 'Thu khác',               'income',  1),
('CP',    'Chi',                     'expense', NULL),
('CP-VL', 'Chi vật liệu',           'expense', 4),
('CP-NC', 'Chi nhân công',          'expense', 4),
('CP-MB', 'Chi máy bơm/thiết bị',   'expense', 4),
('CP-QL', 'Chi quản lý',            'expense', 4),
('CP-LG', 'Chi lương',              'expense', 4),
('CP-KH', 'Chi khác',               'expense', 4);

CREATE TABLE transactions (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reference_code      VARCHAR(50) NOT NULL UNIQUE COMMENT 'Mã phiếu thu/chi',
    department_id       INT UNSIGNED NULL,
    category_id         INT UNSIGNED NOT NULL,
    type                ENUM('income','expense') NOT NULL,
    contract_id         INT UNSIGNED NULL COMMENT 'Liên kết hợp đồng (nếu có)',
    invoice_id          INT UNSIGNED NULL COMMENT 'Liên kết hóa đơn (nếu có)',
    amount              DECIMAL(18,2) NOT NULL,
    transaction_date    DATE NOT NULL,
    description         TEXT NOT NULL,
    reference_doc       VARCHAR(200) NULL COMMENT 'Số chứng từ kế toán',
    attachment          VARCHAR(500) NULL COMMENT 'File đính kèm',
    created_by          INT UNSIGNED NULL,
    approved_by         INT UNSIGNED NULL,
    approved_at         DATETIME NULL,
    created_at          TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id)   REFERENCES transaction_categories(id),
    FOREIGN KEY (contract_id)   REFERENCES contracts(id) ON DELETE SET NULL,
    FOREIGN KEY (invoice_id)    REFERENCES invoices(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by)    REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (approved_by)   REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_type        (type),
    INDEX idx_date        (transaction_date),
    INDEX idx_department  (department_id),
    INDEX idx_contract    (contract_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Sổ thu chi tổng hợp';

-- ============================================================
--  MODULE NHÂN SỰ
-- ============================================================

CREATE TABLE employees (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code            VARCHAR(20) NOT NULL UNIQUE COMMENT 'Mã nhân viên, vd: NV001',
    name            VARCHAR(100) NOT NULL,
    department_id   INT UNSIGNED NULL,
    position        VARCHAR(100) NULL COMMENT 'Chức danh',
    emp_type        ENUM('fulltime','parttime','intern','contract') NOT NULL DEFAULT 'fulltime',
    gender          ENUM('male','female','other') NULL,
    birth_date      DATE NULL,
    cccd            VARCHAR(20) NULL UNIQUE COMMENT 'CCCD/CMND',
    address         TEXT NULL,
    phone           VARCHAR(20) NULL,
    email           VARCHAR(150) NULL,
    bank_account    VARCHAR(30) NULL,
    bank_name       VARCHAR(100) NULL,
    start_date      DATE NULL COMMENT 'Ngày vào làm',
    end_date        DATE NULL COMMENT 'Ngày nghỉ việc',
    base_salary     DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Lương cơ bản (VND)',
    allowance       DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Phụ cấp cố định',
    insurance_rate  DECIMAL(5,2) NOT NULL DEFAULT 10.50 COMMENT 'Tỉ lệ đóng BHXH (%)',
    tax_code        VARCHAR(20) NULL COMMENT 'Mã số thuế cá nhân',
    status          ENUM('active','resigned','terminated') NOT NULL DEFAULT 'active',
    notes           TEXT NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
    INDEX idx_department (department_id),
    INDEX idx_status     (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Danh sách nhân viên';

CREATE TABLE attendance (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     INT UNSIGNED NOT NULL,
    month           TINYINT UNSIGNED NOT NULL COMMENT '1-12',
    year            SMALLINT UNSIGNED NOT NULL,
    work_days       DECIMAL(5,1) NOT NULL DEFAULT 0 COMMENT 'Ngày làm thực tế',
    standard_days   DECIMAL(5,1) NOT NULL DEFAULT 26 COMMENT 'Ngày công chuẩn',
    leave_paid      DECIMAL(5,1) NOT NULL DEFAULT 0 COMMENT 'Nghỉ phép có lương',
    leave_unpaid    DECIMAL(5,1) NOT NULL DEFAULT 0,
    overtime_hours  DECIMAL(6,1) NOT NULL DEFAULT 0 COMMENT 'Giờ làm thêm',
    notes           TEXT NULL,
    created_by      INT UNSIGNED NULL,
    UNIQUE KEY uq_emp_month (employee_id, month, year),
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by)  REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Bảng chấm công hàng tháng';

-- ============================================================
--  MODULE NHÂN SỰ — BẢNG LƯƠNG
-- ============================================================

CREATE TABLE salary_records (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    month           TINYINT UNSIGNED NOT NULL,
    year            SMALLINT UNSIGNED NOT NULL,
    department_id   INT UNSIGNED NULL COMMENT 'NULL = tổng hợp toàn trường',
    status          ENUM('draft','submitted','approved','paid','cancelled') NOT NULL DEFAULT 'draft',
    total_gross     DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Tổng lương trước khấu trừ',
    total_insurance DECIMAL(18,2) NOT NULL DEFAULT 0,
    total_tax       DECIMAL(18,2) NOT NULL DEFAULT 0,
    total_net       DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Tổng thực lãnh',
    payment_date    DATE NULL COMMENT 'Ngày chi lương thực tế',
    notes           TEXT NULL,
    created_by      INT UNSIGNED NULL,
    approved_by     INT UNSIGNED NULL,
    approved_at     DATETIME NULL,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_month_dept (month, year, department_id),
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by)    REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (approved_by)   REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Bảng lương tháng';

CREATE TABLE salary_items (
    id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    salary_record_id    INT UNSIGNED NOT NULL,
    employee_id         INT UNSIGNED NOT NULL,
    work_days           DECIMAL(5,1) NOT NULL DEFAULT 0,
    base_salary         DECIMAL(18,2) NOT NULL DEFAULT 0,
    position_allowance  DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Phụ cấp chức vụ',
    meal_allowance      DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Phụ cấp ăn trưa',
    transport_allowance DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Phụ cấp đi lại',
    other_allowance     DECIMAL(18,2) NOT NULL DEFAULT 0,
    overtime_pay        DECIMAL(18,2) NOT NULL DEFAULT 0,
    bonus               DECIMAL(18,2) NOT NULL DEFAULT 0,
    gross_salary        DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Lương gộp',
    insurance_employee  DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'BHXH NLĐ đóng',
    income_tax          DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Thuế TNCN',
    other_deductions    DECIMAL(18,2) NOT NULL DEFAULT 0,
    total_deductions    DECIMAL(18,2) NOT NULL DEFAULT 0,
    net_salary          DECIMAL(18,2) NOT NULL DEFAULT 0 COMMENT 'Thực lãnh',
    notes               TEXT NULL,
    FOREIGN KEY (salary_record_id) REFERENCES salary_records(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id)      REFERENCES employees(id),
    UNIQUE KEY uq_record_emp (salary_record_id, employee_id),
    INDEX idx_employee (employee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Chi tiết lương từng nhân viên';

-- ============================================================
--  VIEWS HỮU ÍCH
-- ============================================================

-- Tổng quan hợp đồng
CREATE OR REPLACE VIEW v_contract_summary AS
SELECT
    c.id,
    c.code,
    c.title,
    c.status,
    cu.name AS customer_name,
    d.name  AS department_name,
    c.value,
    c.total_value,
    COALESCE(SUM(i.paid_amount), 0) AS total_paid,
    c.total_value - COALESCE(SUM(i.paid_amount), 0) AS outstanding,
    c.start_date,
    c.end_date
FROM contracts c
LEFT JOIN customers  cu ON c.customer_id = cu.id
LEFT JOIN departments d  ON c.department_id = d.id
LEFT JOIN invoices    i  ON i.contract_id = c.id AND i.status != 'cancelled'
GROUP BY c.id;

-- Báo cáo thu chi theo tháng / bộ môn
CREATE OR REPLACE VIEW v_monthly_finance AS
SELECT
    YEAR(t.transaction_date)  AS yr,
    MONTH(t.transaction_date) AS mo,
    d.name                    AS department_name,
    t.type,
    tc.name                   AS category,
    SUM(t.amount)             AS total_amount
FROM transactions t
LEFT JOIN departments          d  ON t.department_id = d.id
LEFT JOIN transaction_categories tc ON t.category_id = tc.id
GROUP BY yr, mo, d.name, t.type, tc.name;

-- Tổng hợp lương nhân viên
CREATE OR REPLACE VIEW v_employee_salary AS
SELECT
    e.code,
    e.name,
    d.name             AS department,
    e.position,
    sr.month,
    sr.year,
    si.gross_salary,
    si.total_deductions,
    si.net_salary
FROM salary_items si
JOIN employees     e  ON si.employee_id = e.id
JOIN salary_records sr ON si.salary_record_id = sr.id
LEFT JOIN departments d ON e.department_id = d.id;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- ENUM REFERENCE
-- ============================================================
--
-- users.role            : superadmin | admin | manager | staff
-- customers.type        : company | school | government | individual
-- customers.status      : active | potential | inactive
-- contracts.status      : draft | active | completed | overdue | cancelled
-- invoices.status       : draft | sent | paid | partial | overdue | cancelled
-- payments.method       : bank_transfer | cash | check | other
-- transaction_categories.type : income | expense
-- employees.emp_type    : fulltime | parttime | intern | contract
-- employees.status      : active | resigned | terminated
-- attendance.* : ngày công lưu dạng DECIMAL(5,1)
-- salary_records.status : draft | submitted | approved | paid | cancelled
-- customer_notes.type   : call | email | meeting | visit | reminder | other
-- tasks.priority        : high | medium | low
-- tasks.status          : todo | in_progress | done | cancelled
--
-- ============================================================
