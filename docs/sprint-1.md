# Sprint 1 - Foundation and Authentication

**Goal:** a running skeleton where admins and employees can sign in and land on their own dashboard.

## Test checklist
| # | Test | Expected | Pass |
|---|------|----------|------|
| 1 | Login as admin with correct credentials | Goes to admin/dashboard.php | [x] |
| 2 | Login as employee with correct credentials | Goes to employee/dashboard.php | [x] |
| 3 | Wrong password | Generic error, stays on login | [x] |
| 4 | Empty fields / bad email | Validation message | [x] |
| 5 | 5 wrong attempts | Temporarily locked | [x] |
| 6 | Employee opens /admin/dashboard.php | 403 | [x] |
| 7 | Open any dashboard while logged out | Redirected to login | [x] |
| 8 | Logout, then press browser Back | Cannot see protected page content after refresh | [x] |
| 9 | Set users.status = 0, then login | "Account is inactive" message | [x] |
| 10 | Submit login form without CSRF token (edit in DevTools) | Rejected | [x] |


