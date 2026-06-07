# Extraction Inventory

Reviewed 15 documents: 14 PDFs in `PHPMIDTERM/PDF` plus `/home/hamail/Downloads/php code forms M.pdf` (121 PDF pages total).

The 11 PHP files are grouped solution files, not 11 questions. After the second audit, the folder contains 27 PHP/code answer blocks. Duplicate exams, answer keys, and repeated pages were merged into the same solution file.

## Source Coverage

| Source | PHP/code extracted | Solution file |
| --- | --- | --- |
| `Mid-Web_oOtsjef_ok5COFV.pdf` | Book search form, Book class, PDO search page, cookie/session/link/output snippets | `10_mid_web_book_object_search.php`, `11_mid_web_cookie_session_snippets.php` |
| `Midterm_2008_cNA0HJw_0f56a2Q.pdf` | No full PHP programming question found; pages are HTML, CSS, JavaScript, regex, and form markup | Not converted to PHP solution |
| `Midterm_2011_lI1jNae_mJJs6pk.pdf` | School database GPA filter page | `01_midterm_2011_school_gpa.php` |
| `Midterm_2014_aBzZasI.pdf` | Cars by race year using a session | `02_midterm_2014_cars_by_year.php` |
| `Midterm_2015_bprVw3h_eKcec51.pdf` | Palestinian universities associative array; repeated GPA question merged with 2011 | `03_midterm_2015_universities_array.php`, `01_midterm_2011_school_gpa.php` |
| `Midterm_2017_LRz6Td0.pdf` | Library search and selected books session total | `05_midterm_2017_library_search_cart.php` |
| `Midterm_Exam_2014_Key_Y0W9fLF_L8206zc.pdf` | Key/duplicate for the cars question | `02_midterm_2014_cars_by_year.php` |
| `Midterm_Exam_2016_Key_FZC2iGO_juBy0BM.pdf` | Players array and form handling | `04_midterm_2016_players.php` |
| `Midterm_oZSMxBm_heiCGfg.pdf` | Repeated GPA and short PHP cookie/link/hidden-field snippets | `01_midterm_2011_school_gpa.php`, `11_mid_web_cookie_session_snippets.php` |
| `Old_Midterm__y9MYPz1_wOvCQ0N.pdf` | Library categories page | `09_old_midterm_library_categories.php` |
| `Web mid.pdf` | Sortable product table, photo upload, photo display | `07_web_mid_sortable_products_and_upload.php` |
| `Web-Midterm-Second-Semester-2022_2023_bkWTA7F_Y8j1CDw.pdf` | Student form, stFavorites.php, course cookie message.php | `08_web_mid_2022_2023_student_favorites.php` |
| `Web_mid_nc2QLqJ_cKt1uav.pdf` | Car rental form, eStore config/products/cart, PHP output snippets | `06_web_mid_estore_cart.php`, `11_mid_web_cookie_session_snippets.php` |
| `midTermMarkingSchema_d815FUG.pdf` | Marking-key duplicate for car rental and eStore questions | `06_web_mid_estore_cart.php` |
| `/home/hamail/Downloads/php code forms M.pdf` | Attached mixed collection; its PHP pages are duplicates of the files above | Merged into the matching solution files |

## Solution Files

| File | Answer blocks |
| --- | ---: |
| `01_midterm_2011_school_gpa.php` | 1 |
| `02_midterm_2014_cars_by_year.php` | 1 |
| `03_midterm_2015_universities_array.php` | 1 |
| `04_midterm_2016_players.php` | 1 |
| `05_midterm_2017_library_search_cart.php` | 1 |
| `06_web_mid_estore_cart.php` | 4 |
| `07_web_mid_sortable_products_and_upload.php` | 3 |
| `08_web_mid_2022_2023_student_favorites.php` | 3 |
| `09_old_midterm_library_categories.php` | 1 |
| `10_mid_web_book_object_search.php` | 3 |
| `11_mid_web_cookie_session_snippets.php` | 8 |

Total: 27 answer blocks.

## Notes

- Repeated pages from the attached PDF were not copied into new duplicate files.
- HTML/CSS/JavaScript-only exam questions were audited and left out unless the form directly belongs to a PHP workflow.
- Old `mysql_*` examples were rewritten using simple PDO code because `mysql_*` is removed in modern PHP.
