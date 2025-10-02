# 🔄 System Workflow Diagram

## Payroll Processing Workflow

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Daily         │    │   Monthly       │    │   Payroll       │
│   Attendance    │───▶│   Processing    │───▶│   Generation    │
│   Recording     │    │   Period        │    │   & Approval    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│ • Check-in/out  │    │ • Calculate     │    │ • Review        │
│ • Hours worked  │    │   working days  │    │ • Approve       │
│ • Overtime      │    │ • Compute       │    │ • Generate      │
│ • Status        │    │   overtime      │    │   payslips      │
│ • Notes         │    │ • Prorate       │    │ • Reports       │
└─────────────────┘    │   salary        │    └─────────────────┘
                       │ • Apply taxes   │
                       │ • Deductions    │
                       └─────────────────┘
```

## User Role Assignment Flow

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   User          │    │   Role          │    │   Access        │
│   Creation      │───▶│   Assignment    │───▶│   Control       │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│ Method 1:       │    │ • Admin         │    │ • Full Access   │
│ Registration    │    │ • HR            │    │ • Employee Mgmt │
│ (No Role)       │    │ • Employee      │    │ • Self-Service  │
│                 │    │                 │    │                 │
│ Method 2:       │    │                 │    │                 │
│ Employee        │    │                 │    │                 │
│ Creation        │    │                 │    │                 │
│ (Auto Employee) │    │                 │    │                 │
│                 │    │                 │    │                 │
│ Method 3:       │    │                 │    │                 │
│ Seeding         │    │                 │    │                 │
│ (Pre-configured)│    │                 │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

## Salary Calculation Process

```
┌─────────────────┐
│   Employee      │
│   Basic Salary  │
└─────────┬───────┘
          │
          ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Attendance    │    │   Overtime      │    │   Allowances    │
│   Calculation   │───▶│   Calculation   │───▶│   & Benefits    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│ • Present Days  │    │ • Overtime      │    │ • HRA           │
│ • Total Days    │    │   Hours         │    │ • Transport     │
│ • Daily Rate    │    │ • Overtime      │    │ • Medical       │
│ • Prorated      │    │   Rate          │    │ • Food          │
│   Salary        │    │ • Overtime      │    │ • Others        │
└─────────────────┘    │   Amount        │    └─────────────────┘
                       └─────────────────┘
                                │
                                ▼
                       ┌─────────────────┐
                       │   Gross Salary  │
                       │   Calculation   │
                       └─────────┬───────┘
                                 │
                                 ▼
                       ┌─────────────────┐    ┌─────────────────┐
                       │   Deductions    │    │   Net Salary    │
                       │   Calculation   │───▶│   Calculation   │
                       └─────────────────┘    └─────────────────┘
                                │                       │
                                ▼                       ▼
                       ┌─────────────────┐    ┌─────────────────┐
                       │ • Tax (10%)     │    │ Net = Gross -   │
                       │ • PF            │    │ Deductions      │
                       │ • Others        │    │                 │
                       └─────────────────┘    └─────────────────┘
```

## Database Relationships

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     Users       │    │   Employees     │    │  Departments    │
│                 │    │                 │    │                 │
│ • id            │◄───┤ • user_id       │◄───┤ • id            │
│ • name          │    │ • department_id │    │ • name          │
│ • email         │    │ • position_id   │    │ • code          │
│ • password      │    │ • basic_salary  │    │ • description   │
└─────────────────┘    │ • employee_id   │    └─────────────────┘
         │              └─────────────────┘
         │                       │
         ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     Roles       │    │  Attendance     │    │   Positions     │
│                 │    │   Records       │    │                 │
│ • id            │    │                 │    │ • id            │
│ • name          │    │ • employee_id   │    │ • title         │
│ • slug          │    │ • date          │    │ • department_id │
│ • description   │    │ • check_in      │    │ • min_salary    │
└─────────────────┘    │ • check_out     │    │ • max_salary    │
         │              │ • hours_worked  │    └─────────────────┘
         │              │ • overtime_hours│
         │              │ • status        │
         │              └─────────────────┘
         │                       │
         ▼                       ▼
┌─────────────────┐    ┌─────────────────┐
│  Permissions    │    │  Payroll        │
│                 │    │   Records       │
│ • id            │    │                 │
│ • name          │    │ • employee_id   │
│ • slug          │    │ • payroll_period│
│ • resource      │    │ • basic_salary  │
│ • action        │    │ • gross_salary  │
└─────────────────┘    │ • net_salary    │
                       │ • working_days  │
                       │ • present_days  │
                       │ • overtime_hours│
                       │ • status        │
                       └─────────────────┘
```

## System Access Control

```
┌─────────────────┐
│   User Login    │
└─────────┬───────┘
          │
          ▼
┌─────────────────┐
│  Role Check     │
└─────────┬───────┘
          │
    ┌─────┴─────┐
    │           │
    ▼           ▼
┌─────────┐ ┌─────────┐ ┌─────────┐
│  Admin  │ │   HR    │ │Employee │
└────┬────┘ └────┬────┘ └────┬────┘
     │           │           │
     ▼           ▼           ▼
┌─────────┐ ┌─────────┐ ┌─────────┐
│• All    │ │• Employee│ │• Own    │
│  Access │ │  Mgmt    │ │  Profile│
│• System │ │• Payroll │ │• Own    │
│  Config │ │• Attendance│ │  Attendance│
│• User   │ │• Reports │ │• Dashboard│
│  Mgmt   │ │         │ │         │
└─────────┘ └─────────┘ └─────────┘
```

## Data Flow Summary

```
1. Daily Attendance Recording
   ↓
2. Monthly Payroll Period Creation
   ↓
3. Automated Payroll Processing
   ↓
4. HR/Admin Review & Approval
   ↓
5. Payslip Generation & Distribution
   ↓
6. Reporting & Analytics
```

This workflow ensures accurate salary calculations based on actual attendance data, proper role-based access control, and comprehensive audit trails for all payroll operations.
