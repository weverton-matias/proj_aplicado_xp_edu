# Changelog

### This is a list detailing changes for all Jetpack CRM releases.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [6.6.1] - 2025-07-10
### Fixed
- Address regression that caused excess queries. [#44267]
- Quote Templates: Clean up link when creating a new quote template. [#44251]

## [6.6.0] - 2025-07-09
### Added
- Tasks: Show completion checkmark in week and day views. [#43940]

### Changed
- Code: First pass of style coding standards. [#42734]
- Code: Introduce version constant in main plugin class. [#41408]
- Code: Load third-party dependencies from build folder. [#43563] [#43778]
- General: Indicate compatibility with WordPress 6.8. [#42701]
- General: Update minimum WordPress version to 6.7. [#43192]
- Improve settings so partial payments can be disabled. [#43316]
- Tasks: Update FullCalendar to latest version. [#43970]
- Update daterangepicker to 3.1.0. [#44016]
- Update package dependencies. [#41286] [#41491] [#41577] [#41659] [#42163] [#42180] [#42384] [#42511] [#42762] [#42809] [#42815] [#43320] [#43326] [#43349] [#43355] [#43356] [#43398] [#43400] [#43425] [#43578] [#43718] [#43734] [#43766] [#43839] [#43892] [#43914] [#43951] [#43990] [#44020] [#44040] [#44148] [#44151] [#44206] [#44215] [#44217]

### Removed
- Code: Remove unused function and images. [#42116]
- Remove Bootstrap dependency. [#43584]
- Remove Onboarding React prototype. [#43577]
- Remove unused legacy code. [#43116]

### Fixed
- API: Fix `companies` endpoint param mapping. [#41508]
- Client Portal: Remove top margin from quotes to ensure the top of the quote is visible. [#41974]
- Client Portal: Show success message when quote is accepted. [#43074]
- Code: Prevent dynamic class properties. [#41857]
- Code: Remove extra params on function calls. [#41263]
- Code: Remove unneeded `data:` URI components. [#43227]
- Code: Update package annotations. [#43322]
- Code: Update stylesheets to use hex instead of named colors. [#42920]
- Code: Update stylesheets to use WordPress font styles. [#42928]
- Contacts: Prevent a PHP warning when adding a new contact when a custom file field exists. [#43234]
- Fix a bug where tax names appended from WooCommerce. [#43306]
- Fix warning for PHP notices on translation. [#44109]
- Invoice line items now import the product short description if set. [#43328]
- JS Packages: Decrease CSS priority of global styles to prevent them from applying within the editor. [#43035]
- Linting: Clean up Stylelint violations. [#43296] [#43322] [#43166] [#43247] [#43213] [#43018] [#43219] [#43019]
- Phan: Exclude generated file from analysis. [#43383]
- Quote Templates: Fix code editor display.
- Tasks: Allow translation of task status after status change. [#43940]
- Tasks: Ensure special characters in tasks are displayed correctly. [#44157]
- Tasks: Ensure task status is consistently toggled. [#43940]
- Tasks: Make it more clear what the current status of a task is. [#43940]
- Tasks: Adjust styles on mobile. [#43940]
- Tasks: Prevent status toggle when pressing enter. [#43940]
- Welcome Tour: Hide upsell prompts when one has a valid license. [#43285]
- Welcome Tour: Restore missing images. [#43804]
- Welcome Wizard: Fix regression in JS. [#41437]

## [6.5.1] - 2025-01-22
### Changed
- Code: Use function-style exit() and die() with a default status code of 0. [#41167]

### Removed
- Remove legacy Groove code. [#41247]

### Fixed
- Invoices: Fix bug introduced in 6.5.0 that prevented email invoices from being sent. [#41172]

## [6.5.0] - 2025-01-10
### Removed
- General: Remove unused legacy code. [#40267]

### Changed
- General: Update minimum WordPress version to 6.6. [#40146]
- API: Allow sort order in endpoints. [#38838]

### Fixed
- CRM: Fix bug which caused duplicated queries to run. [#40711]
- CRM: Fix a fatal error that occurred when exporting contacts with a custom field that had the same name as a linked field (e.g., 'company'). [#38851]
- Dashboard: Fix an issue where the CRM contacts graph displayed incorrect values in some instances. [#38316]
- Dashboard: Show correct avatar for recent activity. [#40280]
- Invoices: Fix bugs in the default PDF template and other fixes. Created a new template to maintain backwards compatibility. [#40514]
- Code: Ensure we use Jetpack Autoloader throughout the codebase. [#40061]
- Migrations: Improve WP Playground compatibility. [#39956]

## [6.4.4] - 2024-08-07
### Removed
- MailPoet: Remove unused MailPoet use statements. [#38453]

### Fixed
- WooSync: Fix a warning message on sync and fatal error when a fee value is not a number [#38570]

## [6.4.3] - 2024-05-23
### Added
- Currency: Added several new currencies to the currency dropdown. [#36897]
- Fonts: Updated core Noto Sans, and added new CJK fonts. [#36962]
- Readme: Adding information on how to contribute to Jetpack CRM. [#36847]
- WooSync: Added new status mapping to avoid creating invoices and transactions from WooCommerce to Jetpack CRM. [#37276]

### Changed
- General: use wp_admin_notice function introduced in WP 6.4 to display notices. [#37051]
- Updated package dependencies. [#36775] [#37147] [#37148] [#37348] [#37379] [#37380] [#37382]

### Removed
- Contact Form: Updated a comment reference to Grunion_Contact_Form_Plugin to be Contact_Form_Plugin. [#37157]

### Fixed
- Companies: Increased city field size from 100 to 200. [#37509]
- Contacts: Increased city field size from 100 to 200. [#37509]
- Invoices: Fix "image not found" logo issue in PDF invoices. [#37311]
- Invoices: Remove the blank line below the contact name. [#37462]
- Listviews: Invoice quick filter status fix to prevent filters not working. [#37048]
- MailPoet Sync: Fix pending pages percentage calculation issue. [#37508]

## [6.4.2] - 2024-04-08
### Added
- Dashboard: Sales Funnel now links to contact list view. [#36272]
- Dashboard: Display red bubble notification in My Jetpack when installation is bad. [#36449]

### Changed
- Dashboard: Only show installation errors on plugins page. [#36390]
- Segments: Increased performance. [#36204]
- WooSync: Added a setting to enable invoices generated by WooCommerce to use the Jetpack CRM invoice reference system. [#36727]

### Fixed
- Data Tools: Cleanup of page logic. [#36273]
- Invoices: Display full statements with long invoice lists.
- Invoices: Enhanced the PDF generation for statements. [#36713]
- Listviews: Status filters are now case-sensitive. [#36232]
- PDF: Improved font reinstallation. [#36704]
- Permissions: Allow users assigned to contacts to view linked objects even if assign ownership is unchecked. [#36239]
- Users: Make sure assigned users are not removed from contacts upon edit. [#36213]

## [6.4.1] - 2024-02-29
### Changed
- General: Indicate compatibility with WordPress 6.5. [#35820]
- Invoices: Total amount calculation in preview and pdf when refunds or credit notes are applied are back to pre-6.4.0 implementation. [#35569]

### Fixed
- Client Portal: Admin banners are now more consistent across screens. [#35575]
- Client Portal: Catch error if Woo order associated with invoice is deleted. [#35689]
- Invoices: Standardize line item code.
- Invoices: Allow long line item descriptions in email. [#35700]
- Listviews: Object status filters now correctly reflect current status options.
- Listviews: Overhaul of listview filter logic.
- Quotes: Add Draft listview filter. [#35827]
- Segments: Allow floats in all numeric segment conditions. [#36047]
- Segments: Fix output if segment has an error. [#36003]
- Tags: Use existing tags if possible when using helper functions to create objects. [#35738]
- WooSync: Catch PHP error if order has empty fee value. [#35802]
- WooSync: Detect and support WooCommerce HPOS configuration. [#35797]
- WooSync: No longer shows today as renewal date if subscription has no renewal date set.
- WooSync: Modernize code.
- WooSync: Remove broken link from settings page.
- WooSync: Prevent addition of the same site more than once. [#35576]

## [6.4.0] - 2024-01-23
### Added
- Database: Added preliminary support for SQLite. [#34868]
- Settings: Add setting to fine tune the Total Value field calculation for contacts and companies. [#34957]

### Fixed
- Backend: Add fallback for dev site detection. [#34867]
- Contacts: Updated default statuses. [#34892]
- Custom fields: More robust fallbacks for slug creation. [#35175]
- Dashboard: Adjust queries for SQLite compatibility.
- REST API: Allow calls when not using pretty permalinks. [#35201]
- Database: Ensure logs table is initiated with all columns. [#34871]
- Fixed: Escape output in typeaheads. [#35171]
- Invoices: Fixed total amount in preview and pdf when refunds or credit notes are applied. [#34211]
- Jetpack Forms: Detect and process custom date fields correctly.
- Custom fields: Gracefully handle invalid date field data. [#34890]
- Listview: Better output escaping in listviews. [#35140]
- System Assistant: Fix broken links on some tasks.
- Migrations: Fix issue where task_offset_fix migration would not mark as complete on some timezones. [#34873]
- Templates: Ensure file paths are valid before trying to load. [#34949]
- Transactions: Better support for SQLite. [#34868]

## [6.3.2] - 2023-12-19
### Changed
- Settings: Make support document links more consistent. [#34695]

### Fixed
- Segments: Fixed an issue preventing segments from being deleted. [#34690]

## [6.3.1] - 2023-12-14
### Added
- WooSync: New `jpcrm_woo_sync_order_data` hook. [#34212]

### Fixed
- Bulk actions: Stricter permissions checks. [#34586]
- OAuth Connection: Updated typo to remove plural connection"s", and removed doc reference for whitelabel builds. [#34446]
- Placeholders: Fixing quote placeholders on the quote template, client portal, pdf and emails. [#34490]
- Quotes: Consistent rendering of dates in placeholders. [#34490]
- Quotes: Consistent rendering of values and currency in placeholders. [#34490]

## [6.3.0] - 2023-11-15
### Added
- API: Add support for creating transactions with custom fields. [#33645]

### Changed
- Requires PHP 7.4 or higher. [#33806]
- Requires WordPress 6.0 or higher. [#33805]

### Fixed
- API: Allow events endpoint to be filtered by owner. [#33789]
- API: The `create_event` endpoint no longer throws a 100 error. [#33712]
- API: Restrict what owner data is returned with events endpoint. [#33736]
- Backend: Prevent error if OpenSSL functions aren't available in PHP. [#33605]
- Backend: Changing how styles are added to the page on several stand-alone pages to prevent WordPress 6.4 compatibility issues. [#33678]
- Client Portal: Better PHP 8.2 support. [#33740]
- Contacts: Fixed display issues on the Add and Edit pages that occurred when moving fields. [#33762]
- Listviews: Remove legacy code. [#33718]
- Mail Delivery: Removed usage of deprecated function utf8_encode. [#33777]
- Quote Templates: Fix issue with notes field rendering HTML entities in some cases. [#33614]
- Quote Templates: Make sure quote titles with apostrophes do not have backslashes added when rendered. [#33596]
- WooSync: Catch PHP error in Client Portal invoice if WooCommerce is disabled. [#33759]
- WooSync: Contacts can now be assigned to existing companies. [#33711]

## [6.2.0] - 2023-10-11
### Added
- Tests: Add mock globals for testing. [#32755]
- Automations: Add new backend in preparation for future release.

### Changed
- Quotes: Allow admin users to accept quotes. [#32738]
- Tasks: Use consistent language in code. [#33221]
- Increase PHP required version to 7.3. [#33003]
- Updated package dependencies.

### Fixed
- API: Rewrite rules are now flushed after enabling module. [#32901]
- API: Task reminder param is no longer ignored. [#33194]
- Better PHP 8.2 support. [#33421]
- CRM Forms: Removed reference to old branding. [#32903]
- CSV Importer: Fixed assignment to companies by name. [#33097]
- Custom Fields: Corrected bug that prevented new address custom fields from being shown. [#33056]
- Invoices: Handle status translations consistently. [#32909]
- Segments: Fixed error 219 occurring when using date ranges. [#32379]
- Tags: Better slug generation and added tag slug migration. [#33121]
- Tags: Prevent duplicate slugs, and adding more robust slug fallback support. [#33096]
- Tasks: Corrected placeholders for contacts and companies in the task reminder email. [#32375]
- Transactions: Filters now work for custom statuses. [#33476]

## [6.1.0] - 2023-07-24
### Added
- Listing pages: Add a new setting that allows listing pages to utilize the full width of the screen [#31904]

### Changed
- General: indicate full compatibility with the latest version of WordPress, 6.3. [#31910]

### Fixed
- API: Fixed error 200 while saving new api connections [#32003]
- Contacts: Fix bug that prevented the creation of contacts WP user for the Client Portal [#31710]
- Contacts: Fix Filter options not available on the main contacts listing [#31517]
- File Uploads: Fix bug that prevented file uploads from working in environments where the PHP finfo_open function was not available [#31527]
- Menu: Improved alignment for items in the menu [#31846]
- OAuth/Gmail: Fix to enable sending links and images in the email content, supporting text/plain [#31943]
- Segments: Fix bug that prevented dates to be saved in some environments [#31628]

## [6.0.0] - 2023-06-21
### Added
- CRM: Revamped CRM User Interface - Merge the sleek aesthetics of Jetpack’s style, bringing a new level of sophistication and seamless navigation to your CRM experience [#30916]
- API: Now it retrieves contacts with tags [#31418]
- Contacts: Allow unsubscribe flag to be removed [#31029]

### Changed
- User roles: Further restricted capabilities on some roles [#31174]
- Contacts: Use sha256 instead of md5 for gravatar images [#31288]

### Fixed
- Client Portal: Fix a fatal error initializing endpoints and shortcodes [#30678]
- CRM: Fix new lines display in quote templates [#30974]
- CRM: Fix whitelabel bug with full menu layout [#31126]
- CRM: Page layout now has a max width of 1551px [#30961]
- CRM: Welcome tour now goes through all steps [#31178]
- Extensions: Catch PHP notice if offline [#31032]
- Invoices: Show assigned contact/company link [#31153]
- Listview: Per-page settings no longer reset
- Listview: PHP notice no longer shows when saving settings [#31154]
- Quotes: Fix sort by status [#31087]
- White label: JPCRM support and resources pages no longer show [#31155]

## [5.8.0] - 2023-05-18
### Added
- Composer: Added jetpack-forms as a required dependency to fix a Jetpack form compat issue [#30749]
- Segments: Adding a doesnotcontain condition for email segments, for better compatibility with Advanced Segments [#30422]

### Changed
- Code cleanup: Cleaning up WP Editor helper functions and wp_editor usage [#30306]
- General: Update link references to releases in changelog [#30634]
- Navigation: Changed Learn More button and Learn More link to be consistent with Jetpack styles [#30135]
- PDF generator: Objects in filenames are translated [#30295]
- WooSync: Improved status mapping logic [#30557]

### Fixed
- Companies: Fix company name prefill so add links - transaction, invoice and tasks - prefill company name [#30752]
- Contact / Company: Fix date styling for transactions, invoices and quotes [#30483]
- Contact / Company: Profile summary total value and invoice count now removes deleted invoices [#30178]
- Custom fields: Use native date pickers [#30643]
- Quotes: Use native date pickers [#30643]
- Export: Contact segments now export company info [#30393]
- Logs: Facebook, Twitter, Feedback, and Other Contact log types now update last contacted timestamp [#30470]
- Settings: Eliminate orphaned references to custom fields within field sorting settings when removing custom fields [#30114]
- Segments: Make sure total count is updated on tag changes [#30638]
- Tasks: Start and end times now show correctly throughout the CRM [#30431]
- Tasks: New migration to remove timezone offset from database [#30431]
- Tasks: Removed reliance on strftime for better PHP 8.1 compatibility [#30431]
- Tasks: Switch to native browser date and time inputs [#30431]
- Tasks: Catch moment.js notice due to using fallback date format [#30431]
- Tasks: Fix ##TASK-BODY## placeholder [#30431]
- Tooling: Allowing minification of JS files in development [#30119]
- Transactions: Always show current status in editor [#30644]
- WooSync: Fix the fee amount from a WooCommerce order is not added to the invoice [#29650]
- WooSync: Fix shipping tax and discount amounts from WooCommerce orders are not calculated in invoices [#29650]
- WooSync: Fix the subtotal amount from WooCommerce orders is not calculated in invoices [#29650]
- WooSync: Fix PHP Warning [#30572]
- Invoices: On invoice update the shipping tax selected is removed resulting on incorrect total amount [#29650]

## [5.7.0] - 2023-04-19
### Added
- Menus: Add back to list button on add and edit pages for companies, transactions, invoices, and quotes [#29999]
- Settings: Remove 'Restore default settings' from the General Settings page, add to settings page menu [#29999]
- Support Page: Add new support page for customers to submit support requests [#29545]

### Changed
- API: Add optional parameter to the API to set the external service name, and replace hyphens from the json response to underscores [#29316]
- Companies: Move status select from Actions to main edit section underneath ID [#29999]
- Contacts: Change location of save button and add Contact Actions metabox for contacts [#29999]
- Onboarding: Change onboarding wizard company name description to remove 'as shown below' [#29999]
- Quotes: Move Quote Status underneath Quote ID [#29999]
- Menus: Swap the stacked logo to the horizontal one [#30092]
- CSV Importer: Various UI/UX tweaks [#29851]
- Dashboard: Align the Latest Contacts and Revenue Chart buttons [#29999]
- Dashboard: Make spacing between panels more consistent [#29999]
- Invoices: Fix overflow issue in the edit invoice page [#29999]
- Invoices: Move status select HTML from Invoice Actions to main edit section under ID [#29999]
- OAuth: Dependencies are now downloaded to wp-content/jpcrm-storage/packages [#29734]
- Onboarding: Make all hint styles consistent [#29999]
- Transactions: Change location of import sub-menu item when CSV Pro is installed and active [#29999]
- Transactions: Move status select HTML from Transaction Actions to main edit section underneath ID [#29999]

### Removed
- Onboarding: Remove company name preview from onboarding wizard [#29999]

### Fixed
- UI: Change fonts to smaller size, and different font family [#29999]
- UI: Change form placeholder colors to a lighter shade of gray [#29999]
- Contacts: Fix 403 error if file was uploaded via Client Portal Pro using Apache web server [#29969]
- Menus: Remove border from top menu [#29999]
- Dashboard: Adjustments to first-use modals [#30065]
- Dashboard: Various fixes for the sales funnel [#29995]
- Email: Caught PHP notices if recipient was deleted [#29747]
- Exports: Catch PHP notice when exporting a subset of objects [#30111]
- UI: Fix content overflowing in contact view page [#29999]
- Support: Fix the Give Feedback link so that it sends to the reviews page on .org [#29873]
- General: Fix various corrupt JS files [#29705]
- Onboarding: Get updates (mailing list) changed from opt-out to opt-in in the onboarding wizard [#29999]
- Importer: Allow import of application/csv mime type
- Importer: Better parsing of CSV fields [#29822]
- General: Improved compatibility with PHP 8.1 [#29945]
- Invoices: Fix ability to remove logo from invoice edit page [#30099]
- Invoices: Fix PHP notice when sending contact an invoice via email [#30110]
- General: Fix broken link in bulk actions function in list view [#29623]
- MailPoet Sync: Fix an issue where contact images would disappear after synchronization [#30091]
- Onboarding: Remove outdated YouTube video from welcome overlay [#29999]
- Quotes: Use current date if quote date is blank [#30032]
- Settings: Fix broken link on white label installs [#30160]
- Settings: Allow new tax rates to be added [#29938]
- Onboarding: Usage tracking changed from opt-out to opt-in in the onboarding wizard [#29999]
- WooSync: Tag existing contacts with new orders [#30107]

## 5.6.0 - 2023-03-23
### Changed
- Contacts: Change customer references to contact in all but Woo and commerce contexts [#29267]
- Compatibility: Indicate full compatibility with the latest version of WordPress, 6.2 [#29341]
- Move all files that were inside the zbscrm-store folder with a flat structure to the new jpcrm-storage folder that uses a hierarchical structure [#28350]
- Extensions: Highlight popular Woo extensions on extensions page, plus alphabetize results [#29199]

### Fixed
- Add a missing < which prevented a script tag from being opened. [#28834]
- Allowing XMLRPC and REST requests when the frontend is disabled [#28970]
- Client Portal: Fix bug that prevented access from being disabled using the contact page [#28675]
- Client Portal: Fix numeric fields, date fields, and textareas in the Client Portal [#28796]
- Change escape function for API generated activity [#29146]
- Contacts: Prevent JS error when custom avatars are not enabled [#29086]
- Contacts: Fix PHP error when using empty values for Address Custom Field (Date) [#29249]
- Contacts: Fix a contact field issue when a Woo order subscription is updated [#28800]
- Contacts: Fix avatar getting removed when saving a contact [#28829]
- Contacts: Fix escape in contact list filters [#28836]
- Contacts: Fix issue where exporting contacts shows "County" when it should show "State" [#28868]
- Contacts: Fix the escape used in the "Bundle holder" notification when uploading files to a contact [#28831]
- Dashboard: Allow custom profile pictures to be shown in the dashboard [#28802]
- Invoices: Escape an invoice ID in ZeroBSCRM.admin.invoicebuilder.js [#28830]
- Tasks: Correct text where tasks where being referred to as events [#29267]
- Placeholders: Fix secondary address placeholders [#29396]
- Placeholders: Fix several placeholders throughout CRM [#29361]
- Placeholders: Fix minor admin only issue on placeholder fields [#28811]
- Exports: Fix some export cases by adding a check for the segment index [#29482]
- Taxes: Fix tax page deletion for single entries [#29227]
- Taxes: Fix tax rate creation link on tax rate settings page [#29209]
- Forms: Swapping edit and new form titles to correctly reflect page [#29274]
- Dashboard: Show default avatar under activity, when contact image mode set to none [#29067]
- Client Portal: Fix accept quote in Client Portal button not working for PHP versions 8.1 and up [#29055]
- Taxes: Fix potential XSS in the Tax Settings page [#29215]
- Contacts: Fix wrong naming from Customer ID to Contact ID in the Edit Contact page [#29267]
- Contacts: Importing contacts using CSV files no longer erases fields that are missing [#28886]
- Client Portal: Background for the menu in the Twenty Seventeen theme is no longer dark gray [#29052]
- OAuth Connections: No longer shows critical error after saving credentials [#29059]
- WooSync: Remove PHP notice when a WooCommerce order is in a Draft status [#29099]
- Segments: Fix list pagination [#29004]
- Fix special characters in textarea fields (contacts, transactions, quotes) to prevent producing visible HTML entities [#28941]
- WooSync: Change status only for contacts with the Lead status [#28908]

## 5.5.3 - 2023-01-26

- Fixed: CRM no longer breaks WordPress sites running on PHP 7.2
- Fixed: HTML escaped code in contact list filters for segments

## 5.5.2 - 2023-01-25

- Fixed: Custom profile images are now shown in the Latest Contacts dashboard
- Fixed: Potential XSS in the Custom Fields setting page
- Fixed: Custom profile pictures are no longer removed when updating contacts
- Fixed: Potential XSS in invoices with manual input references
- Fixed: Code snippet was removed from the top of the Forms new/edit page
- Fixed: Remove HTML code in the "Bundle holder" notification when uploading files to a contact
- Fixed: HTML escaped code in contact list filters for segments
- Fixed: Improved security regarding filenames for uploaded files
- Fixed: The creation date for contacts is updated on any WooCommerce subscription event
- Improved: Added translation for contact fields when exporting contacts
- Improved: Added Invoice Status to PDF Invoice template
- Added: Export Segments to .CSV
- Added: WooCommerce order status mapping to transaction status
- Added: WooCommerce order status mapping to invoice status

## 5.5.1 - 2022-12-16

- Fixed: Inline field editing no longer prevents listings from being displayed
- Improved: Security around phone numbers viewing
- Improved: Added a migration to remove outdated AKA lines

## 5.5.0 - 2022-12-13

- Fixed: negative and zero-balance invoices now show tax subtotals when applicable
- Fixed: Bug where core field conditions Status and Email didn't translate well between Advanced Segments and core Segments.
- Fixed: WooSync removing contact fields while syncing
- Fixed: Empty index.html files are now being added to contacts folders to prevent directory listing
- Fixed: Date and datetime picker issue in Segmentation
- Fixed: Incorrect total value shown for contacts when invoices were deleted
- Fixed: Added missing custom fields in WooCommerce's My Account when using WooSync
- Fixed: Segment editor bugs around some Advanced Segment conditions
- Fixed: Properly delete associated aka (aliases) when deleting contact
- Fixed: Security improvement to prevent XSS attacks escaping output HTML
- Fixed: Reference error which was blocking custom date field editing.
- Fixed: Bug where by some migrations were not finishing
- Fixed: "Your tasks" link now properly filters to your tasks
- Improved: caught PHP warning when creating a new contact with navigation mode enabled
- Improved: one can select "none" for shipping tax rate when editing transactions
- Improved: Refactored date and datetime picker logic to be more robust
- Improved: Segment conditions now have proper positioning and categorisation
- Improved: Styling in Segment editor with the recent addition of lots of new conditions
- Improved: Files for companies, invoices, and quotes are now stored in separate folders
- Improved: Security around Email viewing
- Improved: contact profile activity timeline properly renders newlines
- Improved: custom date fields now have additional _DATETIME_STR and _DATE_STR placeholders
- Improved: default fonts are now bundled with the core plugin
- Improved: Hardened security around CRM client portal account privileges
- Improved: Hardened security against admin-side file uploading
- Improved: Migration system now has multi-load-point potential.
- Improved: cleaned up incorrect/broken learn links
- Added: MailPoet Sync module (Import MailPoet Subscribers into CRM Contacts)
- Added: Export CRM Segment to MailPoet Subscriber list functionality
- Added: MailPoet Contact List View Filter
- Added: Autologging of MailPoet Subscriber changes on contact
- Added: MailPoet Contact View information tab
- Added: Custom profile pictures for contacts now use a new field
- Added: Migration to correct incorrect errors for custom field based Segment Conditions

## 5.4.4 - 2022-11-14

- Fixed: prevent edge case where folder creation may overwrite file
- Fixed: cleaned up unneeded files in plugin zip
- Fixed: System Status sometimes didn't detect default font as installed
- Improved: extra fonts now persist between updates
- Improved: consistent menu order between menu modes
- Improved: allow style attributes on more HTML elements in quote templates
- Improved: Segment condition inputs are now type-aware

## 5.4.3 - 2022-11-10

- Fixed: uploaded files could not be accessed when using Apache
- Fixed: 500 error visiting Client Portal invoices page if logged out and easy-access disabled
- Fixed: transaction date fields properly show timezone offsets
- Improved: custom WP date and time formats no longer cause errors when editing transactions
- Improved: redirect to Client Portal login instead of error if accessing an invoice object URL when logged out and easy-access disabled
- Improved: hardened security
- Added: File listing tab in the contact's page now shows information about who an when a file was uploaded
- Added: transaction paid and completed date fields now allow manual adjustment of time data
- Added: transaction editor now uses native browser date and time inputs

## 5.4.2 - 2022-11-02

- Fixed: Bug in 5.4 which was giving PDF generation a hiccup
- Fixed: Bug in WooSync where customer notes were not being added
- Fixed: Added a workaround for varying encryption cipher support
- Improved: HTML in contact logs now displays properly in the contact single view Activity Log
- Improved: Allow more common-sense HTML elements in Quote Templating

## 5.4.1 - 2022-10-27

- Fixed: catch migration error when using PHP 8
- Fixed: catch migration error when using non-default table prefixes

## 5.4.0 - 2022-10-26

- Fixed: Bug in tax table management where duplications could be added
- Fixed: Bug where WooSync would not make new invoices for orders where order id and Invoice id collided
- Fixed: Bug where by WooSync duplicate customer note logs
- Fixed: Error when accessing Client Portal settings when Client Portal is disabled
- Fixed: transaction type is properly imported with WooSync
- Fixed: error if using old database servers when searching contacts
- Fixed: caught PHP notices when checking for existing object metadata
- Fixed: transactions excluded from calculated totals now show a zero value in invoice partials
- Fixed: one can again regenerate API credentials when using PHP 8
- Fixed: allowed some previously-translatable text to be translated again
- Fixed: calculated tax works with negative invoice line items
- Fixed: Email file attachments (invoices) don't work with Gmail sender method
- Fixed: Style glitch for Payment rows in Invoice Totals table (PDF)
- Fixed: database index tried to add twice on new installs
- Fixed: Segment conditions for custom fields now respect the custom field type when using Advanced Segments
- Fixed: Bug in segmentation logic which affected Advanced Segments 'date added' condition.
- Improved: WooSync now follows WooCommerce tax code usage
- Improved: Database access layer around the storage of log metadata
- Improved: Segment preview audiences are now linked to profiles
- Improved: CSV filenames are now hashed during import for better security
- Improved: numeric custom fields now allow negatives
- Improved: better backend support when uploading files to contacts
- Improved: Updated PDF generation library to latest version
- Improved: Hardened PDF generation routine against local file exposure
- Improved: Segment previews now show randomised contacts.
- Improved: Hardened file checks in CSV Importer
- Improved: Segment condition 'Date range' has been split into 'Date range' and 'Datetime range'
- Improved: wrap more strings for translation
- Added: Ability to Pin and Unpin important logs from a contact
- Added: Segment editor now supports condition categories and descriptions.
- Added: New feature: Totals tables to contact list view
- Added: new "jpcrm_client_portal_after_save_details" hook
- Added: Segment condition type: Variable date windows (e.g. within the past _ days, or in the next _ days)
- Added: Segment condition type: Numeric >=
- Added: Segment condition type: Numeric <=
- Added: Segment condition type: String "Does not contain (!*)"
- Added: Segment condition type: Date >=
- Added: Segment condition type: Date <=

## 5.3.1 - 2022-09-29

- Fixed: PHP notice in WooSync syncing
- Fixed: zbs_end_emails_ui hook sometimes fired twice
- Fixed: error when listing contact or company files
- Improved: Increased reliability of lost-connection notifications in WooSync

## 5.3.0 - 2022-09-28

- Fixed: WooSync properly maps the "On hold" transaction status
- Fixed: custom date fields now work correctly under WooCommerce My Account
- Fixed: Client Portal is now properly aligned when using the Twenty Twenty theme
- Fixed: catch an edge-case API error when no results are found
- Fixed: invoice exports no longer give PHP errors
- Fixed: "Powered by" messaging now consistently respects its setting
- Fixed: "Older than X days" filter works again
- Fixed: reCaptcha form settings are no longer reset
- Fixed: "Select All" button on export page now works
- Fixed: sort by total value sometimes gave an error
- Fixed: uploaded files could not be accessed when using Apache
- Fixed: "My Invoices" link in WooCommerce My Account no longer triggers an error
- Fixed: plain permalinks can now be used with the Client Portal
- Fixed: "Thank You" page from Client Portal is now accessible when using easy-access links
- Fixed: escape translated apostrophes in client portal metabox
- Fixed: PHP notice on task manager when not an admin
- Fixed: segment editor shows correct match type
- Fixed: quotes and invoices in the Client Portal now respect theme colors
- Fixed: custom permalinks no longer break the Client Portal
- Fixed: various security fixes
- Improved: better handling of HTML-encoded content on export
- Improved: Refined the way we protect sensitive data storage
- Improved: removed unused legacy API files
- Improved: renamed undocumented "api_status" endpoint to "status"
- Improved: better handling of relative date output
- Improved: show correct dates in invoices despite timezone variations
- Improved: consolidated various "Powered by" settings into two general settings
- Improved: deleted contacts no longer generate PHP notices in email manager
- Improved: better performance on large sites
- Improved: better API error handling
- Improved: prevent exporting an object type if there are no objects to export
- Improved: API secret is now hashed upon generation for better security
- Improved: new API credentials have "jpcrm_" prefix
- Improved: CRM-only menu choice during welcome wizard no longer enables full WP override setting
- Improved: better messaging when generating a WP user fails
- Improved: prevent saving an invalid email to a contact
- Improved: tweaks to list view settings UX
- Improved: refined messaging on WooSync hub page around paused sites
- Improved: performance boosts to WooSync for large sites
- Improved: removed JS error from console when on the dashboard
- Improved: replaced outdated feedback page with CRM Resources page
- Improved: contacts created via WooSync are now assigned to a company if specified
- Added: custom date fields now show on the Client Portal
- Added: get CRM version info with the "status" endpoint
- Added: invoice list view now has "date" and "due date" columns
- Added: new backend webhook system via API
- Added: new setting to disable WooSync order status mapping
- Added: optional transaction status column in the Client Portal
- Added: "jpcrm_after_contact_update" and "jpcrm_after_contact_insert" hooks

## 5.2.0 - 2022-08-11

- Fixed: bug in Segments which would sometimes block multi-field querying of the same field
- Fixed: Custom CRM Header link was resulting in a broken link
- Fixed: error while sending e-mails when the Client Portal module is disabled
- Fixed: external source record lines are now properly removed on object deletion
- Fixed: invoices updated by WooSync retain their logo
- Fixed: listviews wouldn't load if tags had improperly-encoded characters
- Fixed: local Woo order hooks are ignored if local connection is not active
- Fixed: WooCommerce order lineitem prices were incorrectly mapped to the CRM invoice in some cases
- Fixed: WooCommerce order updates didn't always update the associated CRM invoice
- Fixed: WooSync and GiveWP no longer overwrite the WP user ID link in the database
- Fixed: WooSync now properly sets the contact status
- Fixed: Zapier logic was not loaded properly
- Improved: better PHP 8 compatibility
- Improved: if a GiveWP donation has a date available the CRM will import a transaction using that date
- Improved: invoices missing easy-access hashes will regenerate one when saving in the invoice editor
- Improved: menus items should now load in a consistent order no matter the menu mode
- Improved: refactor of Client Portal backend code
- Improved: refinements to mail delivery setup wizard
- Improved: removed old dompdf library
- Improved: switching between tabs in the System Assistant page now updates the URL
- Improved: visual tweaks and refinements
- Improved: WooSync now connects to external stores via authentication dialog, rather than credentials (simplified)
- Added: increased minimum PHP version to 7.2
- Added: CRM settings are now found in the Jetpack CRM menu
- Added: Gmail via API as a mail delivery method
- Added: OAuth 2.0 Connection support for Google
- Added: Package Installer to support sideloading of larger dependencies
- Added: WooSync can now synchronise data from multiple WooCommerce stores into one CRM instance
- Added: WooSync now has 'pause sync' mode per store connection

## 5.1.0 - 2022-06-30

- Fixed: unpaid/uncompleted transactions imported from Woo now show a blank completed/paid date
- Fixed: orders could be skipped if they didn't exist during partial order page retrieval
- Fixed: domain field in WooSync settings no longer shows 0 if blank
- Fixed: WooSync connection settings did not toggle visibility properly in some cases
- Fixed: WooSync now correctly reports partial percentage of pages completed
- Fixed: second address custom fields can now be used as columns in a list view
- Fixed: second address label is now properly used throughout the CRM
- Fixed: orders from external sites were sometimes not synced
- Fixed: data imported from GiveWP now adds to existing tags instead of replacing them
- Fixed: the Client Portal page can now be set as the homepage
- Improved: transaction statuses imported from Woo are now properly shown when editing a transaction
- Improved: 0% tax rates are now possible
- Improved: better translation support on tax settings page
- Improved: ensures the zbs_end_emails_ui action fires on the single email page
- Improved: WooSync hub now syncs latest data on load
- Improved: better translation support for second address fields
- Improved: catch a PHP notice when processing a Jetpack contact form
- Improved: WooSync Hub stats automatically update during AJAX sync
- Improved: The transaction listing in the Client Portal now shows the transaction status
- Added: WooSync Hub now supports syncing orders that have a custom number structure
- Added: new _DATETIME_STR and _DATE_STR placeholders based on unix timestamp values

## 5.0.1 - 2022-06-05

- Fixed: emails properly send when a quote is accepted
- Fixed: catch Woo API headers when server maps them to lowercase keys
- Fixed: catch division by zero error in Woo edge cases
- Improved: removal of legacy code
- Improved: contact placeholders can now be used in system email templates
- Improved: update link to Woo learn content
- Improved: better handling of larger numbers in WooSync hub

## 5.0.0 - 2022-05-25

- Fixed: Contact/company creation logs now show more useful data when created from external source.
- Fixed: Bug where in some external site syncing situations external sources were duplicated in WooSync
- Fixed: Segment date range outputs correctly when editing
- Fixed: WooCommerce Bookings from the current day are now correctly listed.
- Fixed: Database query filter bug around external source retrieval
- Fixed: Contact names now show on company list view when contact image mode is set to none
- Fixed: Caught PHP notice when regenerating API keys
- Improved: External source system now records 'origin' (Domain) for external sources.
- Improved: WooSync now records domain origins for Synced orders and customers.
- Improved: Expanded DAL to allow additive tagging.
- Improved: External source system now displays grouped by source, with clearer UI.
- Improved: Added support so that Advanced Segments can segment by External Source
- Improved: WooSync now stores Order ID above Post ID.
- Improved: Refined query engine surrounding setting retrievals
- Improved: WooCommerce integration performance
- Improved: Cleanup of white label code
- Improved: Refund transaction support improved throughout.
- Improved: Increases the interval of the WooSync cron job
- Improved: Increases the number of Woo orders retrieved per page
- Improved: Local WooCommerce order trashing and deleting are now caught by WooSync Sync.
- Improved: Add a notice to not allow to reactivate WooSync extension in Jetpack CRM v5+
- Improved: Reduced amount of migrations, unified, simplified, optimised!
- Improved: Brought base data model up to date with v3.0 DAL for fresh installs
- Improved: Core CRM modules now have autoloading.
- Added: WooSync module is now bundled in the core!
- Added: WooSync module can now be enabled in welcome wizard
- Added: Two new segment conditions, "Is WooCommerce Customer" and "WooCommerce Order Count".
- Added: Added filter bar button "Woo Customer".
- Added: System Assistant steps for the Woo module
- Added: Automatic switching routine to let WooSync core module seamlessly replace the Extension variant.
- Added: Update link to go to Woo hub from first use dashboard
- Added: Support for new WooCommerce related Advanced Segments
- Added: Support for WooCommerce Checkout Field Editor fields in WooSync
- Added: Support for WooCommerce Checkout Add-Ons in WooSync
- Added: Support for Checkout Field Editor (Checkout Manager) for WooCommerce
- Added: New Quick Filter: Invoice from WooCommerce
- Added: New Quick Filter: Transaction from WooCommerce
- Added: Email and name changes made on WooCommerce My Account are now reflected against attached contacts.
- Added: Email and name changes made on WordPress profile edits are now reflected against attached contacts.
- Added: Support for WooCommerce refunds

## 4.11.0 - 2022-04-21

- Fixed: WP users are now consistently created if "Generate WP User" is selected
- Fixed: Client Portal width in the Twenty Twenty-Two theme
- Fixed: Broken link on activating CRM API
- Fixed: Invoice labels now display properly on PDFs and on portal invoices
- Fixed: one can again send an invoice to the email of choice
- Fixed: DB migration collision
- Improved: prevent upload folder directory listing on misconfigured web servers
- Improved: learn menu code tweaks
- Improved: set the transaction paid completed" dates to match transaction date if not specified in the transaction editor
- Improved: redirect CRM contacts to client portal after login at /wp-admin/
- Improved: better client portal password reset flow
- Improved: better Zapier search support
- Improved: dashboard revenue chart is fully based on transaction date instead of transaction date paid
- Improved: wrapped a few more strings for translation
- Improved: prevent WP button text from being changed in edge cases
- Added: new "api_status" API endpoint to verify credentials
- Added: You can now display Invoice custom fields on invoice PDFs and portal invoices.
- Added: You can now display Contact/Company custom fields on invoice PDFs and portal invoices.
- Added: Preparations for v5.0 major release

## 4.10.3 - 2022-03-30

- Fixed: transaction list doesn't work on sites with unexpected table prefixes.
- Fixed: Issue installing the plugin via XML-RPC request.
- Improved: move welcome tour behind first use dashboard modal.

## 4.10.2 - 2022-03-28

- Fixed: issue installing the plugin via WP-CLI command line
- Fixed: updates now show consistently
- Fixed: some menus did not load on white label installs

## 4.10.1 - 2022-03-25

- Fixed: Error on new first use dashboard
- Fixed: Incompatibility with PHP versions prior to 7.3
- Improved: better compatibility with block-based themes

## 4.10.0 - 2022-03-24

- Fixed: quotes can now be accepted in block-based themes
- Fixed: prevent a JS error when TinyMCE is used by another plugin
- Fixed: edit user-created logs when created in another language
- Improved: Styling around admin notices on various pages
- Improved: support addition of tags via Jetpack contact form block's checkbox group
- Improved: removed references to non-existent asset maps
- Improved: Refactored learn menu system
- Improved: Updated Noto fonts to provide more global character support
- Improved: Added new settings page: Locale
- Improved: string cleanup
- Improved: extension update detection code
- Improved: handle null transaction names
- Improved: better WP user creation logic
- Improved: catch PHP notice when creating a contact from Jetpack Forms
- Improved: caught PHP notice that sometimes occurred within built-in forms
- Improved: catch PHP notices when saving logs
- Added: Transaction list can now show External Source column
- Added: Include external source ID when searching transactions
- Added: Ability to install region-specific fonts for PDFs
- Added: New first-use dashboard to better welcome new users
- Added: WooCommerce variant of first use dashboard
- Added: Content to learn menus, including video guides

## 4.9.1 - 2022-02-22

- Improved: Better compatibility with Jetpack plugin

## 4.9.0 - 2022-02-16

- Fixed: Wording for Client Portal is now consistent
- Fixed: error when creating WooCommerce orders with PHP 8.x
- Fixed: catch PHP notice when adding a new contact
- Improved: contacts can now be unassigned
- Improved: discoverability of core CRM modules
- Improved: handle long file titles and descriptions
- Improved: fix import icon on contact menu
- Improved: prevent Jetpack "Add Contact Form" button from showing on quote pages
- Improved: Client Portal tab in contact view was moved to sidebar
- Improved: cleaned up client portal permissions code
- Added: "Assigned to Me" and "Not Assigned" filters for contacts
- Added: further support for Mail Campaigns imminent release
- Added: cron monitoring system to keep the cron jobs alive
- Added: better compatibility for installation via Jetpack

## 4.8.1 - 2022-01-20

- Fixed segment compilation error if using a segment condition that was no longer available

## 4.8.0 - 2022-01-20

- Fixed: bug when apostrophes are present in the business name while sending emails
- Fixed: contact ownership wasn't properly set when creating or updating a contact via the API
- Fixed: cron jobs were not being properly deleted on deactivation
- Fixed: Removed faulty character
- Fixed: setting deletion function
- Improved: better API error messaging
- Improved: newlines are preserved in new emails sent from the Email Manager
- Improved: summary boxes now show in the dashboard if there are no contacts
- Improved: prevent errors if there are duplicate meta keys for a contact
- Improved: transactions created via the API now have a transaction date
- Improved: messaging around Client Portal Pro contact files updated for several scenarios
- Improved: segment failsafes for code extensions such as Advanced Segments
- Improved: UI for the Client Portal is now responsive
- Improved: WP 5.9 compatibility

## 4.7.0 - 2021-12-16

- Fixed: catch error if list view has no filter buttons
- Fixed: pagination didn't update when changing listview settings
- Fixed: second address fields in client portal now save properly
- Improved: show "access restricted" message when one has no access to said object
- Improved: using Safari to send email now works as expected
- Improved: legacy "Auto-draft Garbage Collection" no longer shows on System Status page
- Improved: User Profile page improvements
- Improved: contact edit layout now shows properly if addresses are show last
- Added: pagination and bulk actions now show at the top of listviews

## 4.6.0 - 2021-11-18

- Fixed: non-hidden fields can be blanked from the Client Portal
- Fixed: hidden fields cannot be changed from the Client Portal
- Fixed: all placeholders now work if WP is set to another language
- Fixed: the client portal button placeholder works properly in manually-sent invoice and quote emails
- Fixed: white label sites no longer have a PHP error
- Improved: better cache-busting for JS/CSS files
- Improved: better handling of avatar settings
- Improved: Segment conditions are more reliably respected when building segment counts
- Improved: Support for placeholders in single send emails.
- Improved: better logging when a customer updates details from the Client Portal
- Improved: log types for disabled modules no longer show when adding logs
- Improved: HTML string cleanup
- Improved: placeholder replacement order in single-send emails
- Improved: show contact IDs when merging contact records
- Improved: more robust rewrite rule handling of invoices in the client portal
- Improved: clean up PHP debug code
- Added: check for mb_internal_encoding support

## 4.5.0 - 2021-10-20

- Fixed: Resolves occasional error when sending emails via Email Manager
- Fixed: Sending emails sometimes had extra newlines
- Fixed: reCaptcha on built-in forms wasn't properly working
- Fixed: Custom field settings could overwrite themselves in rare cases
- Fixed: Bug where users could not clear tags against objects.
- Fixed: Updated some WooCommerce doc broken links.
- Fixed: Calendar shows the newer events first (with a 50000 limit)
- Improved: Email Manager messaging tweaks
- Improved: Custom field settings now hide when their module is disabled
- Improved: Cleaned up boxes on the dashboard
- Improved: Refinements to segment caching routines
- Improved: Added more translation support
- Improved: Refinements to single quote client portal page, and other refactoring around templates
- Improved: Moved main email template into templating system (can now be modified via theme file)
- Improved: Added security to templates directory to avoid any possible external indexing
- Improved: Welcome to Client Portal email now supports ##ASSIGNED-TO-EMAIL## etc.
- Added: Show assigned user on contact profile
- Added: New GiveWP core module
- Added: Support for file templates for Invoices, Quotes, and Statements (PDFs)

## 4.4.0 - 2021-09-24

- Fixed: Bug where email template test emails were being sent blank
- Fixed: Cleaned up some PHP notices in the client portal
- Fixed: removed obscure and long-broken setting
- Fixed: Some steps in the welcome tour are not working well
- Fixed: Now Client Portal supports multi slug levels
- Improved: Better messaging on licensing page
- Improved: Add link to task list view on task edit page
- Improved: Wrapped some missed strings for translation
- Improved: Better compatibility with WordPress.com menus
- Improved: File cleanup
- Improved: More strings are available for translation
- Improved: Added better support to custom field creation to avoid key name collisions
- Improved: Better handling of form custom fields
- Improved: Small design tweaks
- Improved: backend translation updates
- Added: New system-wide placeholder system
- Added: New System Assistant page
- Added: Placeholder map reference page

## 4.3.1 - 2021-09-03

- Improved: Some promo banners

## 4.3.0 - 2021-08-25

- Fixed: You are now able to load more than 100 calendar items per page load.
- Fixed: Contact edit link icon.
- Fixed: cleaned up PHP notice when exporting linked objects.
- Fixed: the company column in the contact list view is no longer truncated.
- Fixed: Tweaked previous invoice security fix code.
- Improved: use fallback text in invoices and transactions if contact has no name or email.
- Improved: subtotal column widths are now consistent.
- Improved: items can now be unassigned after a previous assignment.
- Improved: image alt attributes on the extensions page now show properly.
- Improved: Some welcome copy and pics.
- Improved: Removed some unused images.
- Improved: one can now set date custom fields more than 5 years in the future.
- Added: Tasks can now be viewed in a list view as well as calendar view.
- Added: Task bulk actions: add/remove tags, update status, delete.
- Added: Task quick filters: next 7 days, past 7 days, incomplete, complete, etc.
- Added: update contact status in bulk.
- Added: The changelog.txt file with the full release changes.
- Added: Track usage and CRM stats to help us develop features in the most used areas of the CRM.
- Added: the percent discount now shows on invoices when applicable.

## 4.2.3 - 2021-08-11

- Fixed: Invoices and Invoice list not shown on my account unless assigned to you.

## 4.2.2 - 2021-08-09

- Fixed: Hotfix for bug introduced in 4.2.0 with regards tag editing against contacts.

## 4.2.1 - 2021-08-05

- Fixed: Invoices cannot be sent to the assignment contact email.

## 4.2.0 - 2021-08-04

- Fixed: the welcome wizard respects which extensions were selected
- Fixed: invoice lineitem descriptions have newlines preserved
- Fixed: editing contacts assigned to another user is restricted if "Assign Ownership" setting is disabled
- Improved: Cleaned up HTML validation
- Improved: better handling of contacts with no name or email
- Improved: use default quote template values if quote field is empty
- Improved: active core extensions will remain active on refresh
- Improved: cleaned up PHP notice when creating forms
- Improved: cleaned up deprecated jQuery code
- Improved: datepickers now respect WP's "week starts on" setting
- Improved: better Client Portal support for the default Twenty Twenty-One theme
- Improved: Added client portal dialog to contacts without emails in contact view mode
- Improved: Linked object fields can now be exported for Contacts, Quotes, Invoices, and Transactions
- Improved: the "perpage" and "page" params are now available at all relevant API endpoints (customers, companies, transactions, invoices, quotes, customer_search, events)
- Improved: show transaction name on the contact profile page
- Improved: hide total value on contact and company profile when transactions and invoices are disabled
- Improved: DAL improvements allow passing of generic tag_input
- Improved: links are detected in custom text fields
- Added: quick links to create new items from the document tabs
- Added: navigation mode now applies to companies as well as contacts

## 4.1.0 - 2021-07-08

- Fixed: Contact second address custom fields now show in View mode
- Fixed: Display second address if first address is empty
- Fixed: Company custom fields will now always show in View mode
- Fixed: Hide company settings when B2B mode is disabled
- Fixed: The jpcrm_quote_accepted hook works with the quote editor too and not only via Client Portal
- Fixed: The /events API endpoint returns events
- Fixed: Hide Companies section in non-Slimline menu layouts
- Fixed: Don't allow quote template builder to run if customer isn't selected
- Fixed: Contact logs could show doubled in some cases
- Fixed: The "show prefix" setting is now respected when editing contacts
- Fixed: Events now properly show in day and week view
- Improved: Cleaned up PHP warnings related to list view filters
- Improved: Text wrapping in contact and company fields
- Improved: Removed unneeded JS files
- Improved: Contact prefixes and countries can be unset
- Improved: better handling of very long tags
- Improved: CRM deprecation notices are now logged
- Improved: Wrapped some missed strings in __() for translation
- Improved: Blank custom fields now show correctly when viewing a contact profile
- Improved: Search by phone will ignore spaces and common punctuation
- Improved: Typeahead limit has been raised from 5 to 10

## 4.0.17 - 2021-06-24

- Fixed: An internal variable naming for DAL version 2
- Fixed: No break lines in PDF quotes.
- Fixed: Country field is not showing on company address
- Improved: all pages should have titles now

## 4.0.16 - 2021-05-25

- Fixed: Updated PDF library that fixes some issues with the pdf of quotes and invoices using PHP 8
- Improved: Some text banners and buttons

## 4.0.15 - 2021-04-09

- Fixed: Invoice client portal was incorrectly saving the invoice total
- Fixed: Country field is not showing on contact cards
- Fixed: Item selector for invoicing, with long names have a UI issue
- Improved: A better alert message when a user tries to create an invoice with a duplicated reference
- Added: A notice block for announcements.

## 4.0.14 - 2021-03-12

- Fixed: An issue with the set_time_limit in some shared hosts.
- Improved: The CRM dashboard view with date ranges.
- Tested: Tested with WordPress 5.7

## 4.0.13 - 2021-02-25

- Fixed: Added date column in the contact list is using UTC time.
- Fixed: Add a link to the contact ID column in the contact list.
- Fixed: WooCommerce <-> JPCRM conflict importing CSV file with products.
- Fixed: Fix an overflow in custom fields that use a textarea as type.
- Fixed: A collision between the slugs of Jetpack and Jetpack CRM extensions.
- Fixed: The dashboard contacts card, when it's empty, doesn't have padding.
- Improved: Now the transactions have available the hidden fields net, discount, fee.

## 4.0.12 - 2021-02-11

- Fixed: The setting API menu is visible after activating the API core extension.
- Improved: Move the EUR symbol to the top of the currencies selector

## 4.0.11 - 2021-02-01

- Fixed: Company activity log now shows the right time regardless of WP installation timezone
- Fixed: In some cases Invoice ID was lost when updating
- Fixed: Custom label for invoice ID now properly used throughout
- Fixed: Apostrophes in company and contact names now display properly throughout
- Fixed: Started work on PHP 8 support (fixed deprecation notices)
- Improved: Readme (.org description) improvements for readability, added more FAQs
- Improved: Settings now casted better, will overcome core extension loading issues for a handful of users on strict php installs
- Improved: Made menu adjustments for users using Jetpack and Jetpack CRM on the same install, for easier navigation

## 4.0.10 - 2020-12-17

- Fixed: Duplicated title in the short description logs when creating quotes, invoices, transactions and tasks
- Fixed: Custom field with auto-number broken with empty prefix
- Fixed: PHP notice for some users from email tracking system
- Fixed: Labels now again fully respect locale
- Improved: Hardened output of contact list on dash
- Improved: Hardened parsing of CSV files
- Improved: Custom field types numeric and numeric (decimal) are now reliably sortable via list views

## 4.0.9 - 2020-12-10

- Fixed: Migration issues where Jetpack CRM is installed with wp-cli
- Fixed: List views with 'Latest Contact' columns now load properly regardless of DB environment
- Fixed: PHP notice around quotes on contact view
- Fixed: Quote and Task auto-logging now working correctly
- Improved: Removed legacy country-check code
- Improved: Quote send via email now allows for optional attachment of quote as a pdf, or any associated files
- Improved: Hardened the security around the updating of activity logs
- Improved: Resolved a false-positive security flag in a security plugin (removed pclzip)
- Improved: Removed some logs from the Javascript console and some PHP notices
- Improved: Verified WordPress 5.6 support
- Added: New auto-log: Add an activity log to a contact on Quote Accepted
- Added: New hook jpcrm_quote_accepted

## 4.0.8 - 2020-11-25

- Fixed: Company label setting now respected throughout (e.g. Organisation)
- Fixed: Typeahead contact->company assignment for new contacts now displays properly
- Fixed: You can now have many filters without the view blocking access to them
- Improved: Event notification email templating
- Improved: Event notification email template: Took translations out of template file
- Improved: .org description improvements
- Improved: B2B mode is now a core extension and enabled by default
- Improved: Company settings unified into one settings page
- Improved: Transaction settings unified into one settings page
- Improved: Language labels surrounding company and transaction settings
- Improved: Removed legacy file
- Improved: Better styling around large elements on list views
- Added: You can now use an auto-number sequence as reference in invoices (with prefix and suffix)
- Added: Ability to change the label of 'Reference' for invoices
- Added: Signposting to Company settings page
- Added: DAL functionality for retrieving events and event reminders based on reminder status
- Added: Migration to update event notification email template

## 4.0.7 - 2020-11-12

- Fixed: Dompdf exception creating quotes with Preformatted option selected
- Fixed: Style bug when displaying multi-option custom fields on the contact and company view page
- Fixed: Bug where license system modal sometimes reloaded to an incorrect URL
- Fixed: Bug in permissions around verifying back end users
- Fixed: Removed internal PHP notice in Invoices section
- Fixed: Sorting contact list view by company now works properly
- Fixed: Bug where some logs were not showing under 'latest log' column (due to ownership)
- Fixed: Incorrectly referenced second address fields in DB Object model for companies
- Fixed: Total transaction column value on company list view
- Fixed: Several fields were not displaying properly in quote list view
- Fixed: A deep bug in address custom fields where those fields with hyphens in the key were unsortable
- Fixed: A bug where contact last contacted date was incorrectly showing as last updated value
- Improved: Support for checkbox and multi-select custom fields
- Improved: Keywords used for .org repository listing
- Improved: Settings now accessible directly from within module (e.g. Invoices) via learn bar button
- Improved: Corrected company name references
- Improved: License system modal notice language and UI
- Improved: License system update checks
- Improved: You can now search for Transactions, Quotes, Invoices, and Companies by ID
- Improved: Default sort order of DESC now reflects properly in list view sort icon
- Improved: Centralised definitions of "Contact" type logs
- Improved: Better formatting for 'added' date in company list view
- Added: Ability to sort contact list view by: Latest Log
- Added: Ability to sort contact list view by: Latest Contact Log
- Added: Ability to sort contact list view by: Has Quotes, Has Invoices, Has Transactions
- Added: Ability to sort contact list view by: Quote, Invoice, and Transaction count
- Added: Ability to sort company list view by: Name, Status, Email, and other standard fields
- Added: Ability to sort company list view by: Custom fields
- Added: Ability to sort company list view by: Number of contacts at company
- Added: Contact list view column "Has transactions"
- Added: Company list view columns: Has Invoices, Has transactions, Invoice Count, Transaction Count, Transaction Value, Total Value (and made them sortable)
- Added: Ability to sort quote list view by all columns
- Added: Ability to sort invoice list view by all columns
- Added: Ability to sort transaction list view by all columns
- Added: Ability to sort form list view by all columns
- Added: Last Updated column to contacts and companies

## 4.0.6 - 2020-10-29

- Fixed: Duplicated tag with international characters when they are added to a contact
- Fixed: Style issue with Second Address block in the Client Portal
- Fixed: Invoice line items now able to be added to invoices (req invoicing pro v2.7.1)
- Fixed: Textarea custom field doesn't show new lines in view mode
- Fixed: Remove Advanced Search (can search from list view mode since v3.0)
- Fixed: JPCRM cannot be installed if the API Connector plugin is already installed.
- Fixed: Style issue mapping the fields in the CSV Importer section

## 4.0.5 - 2020-10-15

- Fixed: Deleted segment shows as filter contact list view
- Fixed: On export the contact or the transaction list, in the CSV file the owner ID was blank
- Fixed: Wrong menu link showing task tags in CRM only mode
- Fixed: Forms now track visits and conversions properly
- Improved: Better mapping of older extension names into extension system
- Added: Exporting objects owners now also exports owner username
- Added: Core Extensions List updated with latest extensions

## 4.0.4 - 2020-10-02

- Fixed: Issue related to contact and company bulk action deletion
- Fixed: Old brand reference on CSV importer page
- Fixed: New Company placeholder more specific to a real business
- Fixed: Multi-value custom fields in client portal
- Fixed: JPCRM roles for contacts explicitly deny WP role capabilities when activated
- Fixed: A user role still referenced the old brand
- Fixed: Create new invoices without selecting a due date was showing up as Invalid Date
- Fixed: Extension documentation links
- Fixed: In the single contact view, the Invoices Total and Quotes Total now show their correct values
- Fixed: Country field properly shows on contacts/companies
- Fixed: Disabled modules show in the sidebar for CRM-only and Full layouts
- Improved: Task scheduler now shows owner avatars
- Improved: Contact List view can now be sorted by Total value as well as Quotes, Invoices, and Transactions total values
- Improved: Form submission logs
- Improved: Addressed stray PHP notices
- Improved: Tweaked extensions detail page
- Improved: Updated error messaging
- Improved: Beginning of internal refactor of the API

## 4.0.3 - 2020-09-17

- Fixed: API docs link was incorrect
- Fixed: Form widget now works as expected
- Fixed: Restored user filter for tasks
- Fixed: Custom field doesn't show up the dates previous to 1970
- Improved: Revenue chart on CRM Dash
- Improved: Added gender-neutral contact prefix
- Improved: Settings navigation styling
- Improved: More robust paid extension handling
- Improved: Tweaked list view columns
- Added: Mail activity log type

## 4.0.2 - 2020-09-04

- Fixed: Dashboard Revenue Chart was missing some transactions
- Fixed: Customer pre-fill now pre-fills properly.
- Fixed: Date paid and date completed now always filled
- Fixed: Bulk selection not working in WP5.5+
- Fixed: WP5.5+ jQuery function support
- Fixed: Some learn buttons were appearing behind some other elements
- Fixed: Custom dates like Birthday were not allowing pre 1970 date entries
- Fixed: Logo hover icon for fullscreen now turned black from white on white
- Fixed: Author update to be Automattic
- Fixed: Task status labels now format the colour of the label
- Improved: Dashboard Revenue Chart now shows 12 months

## 4.0.1 - 2020-08-20

- Fixed: AJAX.php file was being detected as a virus by some AV scanners
- Fixed: Removed unnecessary notification after plugin installation
- Fixed: the Jetpack Forms extension name
- Fixed: Edit profile avatar sometimes not aligning correctly
- Fixed: Transaction creation prefill now works
- Fixed: View button on transaction (after assigning a contact) now takes you to view, not edit
- Fixed: Clicking a sent email was not loading email correctly
- Fixed: Date Paid field is now in correct format in transactions list view.
- Improved: Made links open in parent tab rather than new tab where it made sense to do so
- Improved: Store the name from a Jetpack contact form submission
- Improved: The Jetpack Forms extension will now be enabled by default when the settings are initialized or reset
- Added: Use the Jetpack contact form toggle setting to determine whether to save the contact
- Added: Ability to hide prefix field

## 4.0.0 - 2020-07-20

- Jetpack CRM branding

## 3.0.19 - 2020-07-10

- Fixed: Fix for a migration bug where date custom fields were not yet translated to v3 data types
- Fixed: A problem that meant no message was shown when a contact is added with a duplicate email address
- Fixed: Bug preventing forms from loading
- Fixed: Company details now show on invoices
- Fixed: multi-select custom fields in invoices now work
- Fixed: An issue with the display of IDs for invoices and quotes
- Fixed: An issue that made contacts having default status of 'Customer', ignoring the setting
- Improved: French translation tweaks
- Improved: Client Portal CSS
- Improved: Special character handling in task titles
- Improved: Custom field placeholder prompts
- Improved: Contact status styling tweaks. on dashboard
- Improved: tweaked appearance of quotes and invoices on contact profiles
- Improved: Address translations and tweaks
- Improved: Role display on team page
- Improved: Invoice display tweaks
- Improved: Removed Select2 dependency
- Improved: Brought more strings properly into internationalisation functions.

## 3.0.18 - 2020-06-29

- Fixed: Migration bug for very few users when using advanced segments and woosync
- Improved: Ahead of a potential XSS vulnerability, and for simplicity, we've removed Select2 js from the CRM
- Improved: Added better catching to the custom field DAL check for multiple lines
- Improved: Security surrounding storage of SMTP credentials

## 3.0.17 - 2020-05-20

- Fixed: Bug where bulk-actions were reset if selecting multiples after the fact
- Improved: Added support for fractional quantities in line items
- Improved: Tidied up some old CPT usage in DAL3
- Improved: Extension buy now links go to product pages

## 3.0.16 - 2020-05-07

- Fixed: Bug where client portal custom fields of type Checkbox were not displayed properly
- Fixed: "Show/Hide Countries" option now respected throughout
- Fixed: Duplicate title text on Client Portal
- Fixed: Type conversion bug in migrations in 3.0.14+
- Fixed: Bug where invoices were not loading if Client Portal deactivated
- Fixed: Bug where transactions were not properly migrating in some cases
- Fixed: PHP warning from transaction statuses mechanism
- Improved: Date custom fields can now be left empty
- Improved: Moved away from compact function use as it now throws notices in PHP 7.3.0+ (Mail delivery methods)

## 3.0.15 - 2020-04-21

- Fixed: Migration bug for new installs
- Fixed: CSV importer now shows localised field labels
- Improved: Performance improvement by asserting autoload=no across non-critical options
- Improved: Removed legacy code
- Improved: Clarified labels on Field Options settings page
- Improved: Removed outdated comments

## 3.0.14 - 2020-04-06

- Fixed: SQL compilation error
- Fixed: Bug where quote dates were saving incorrectly
- Fixed: Bug where transaction datetimes were saving incorrectly
- Fixed: Bug in Statement PDF generation
- Fixed: Bug in Segment audience preview when using international characters in conditions
- Fixed: Bug in Segment audience building when using international characters in conditions
- Fixed: Bug in transaction status inclusion when using international characters
- Fixed: Bug where custom transaction statuses stopped invoice partial assignment
- Improved: Refactored code around custom field views, centralising & tidying
- Added: Company single view now shows custom fields
- Fixed: Bug where v3 forms were not displaying customisations
- Improved: Forms refactored

## 3.0.13 - 2020-03-25

- Fixed: Custom fields now support Chinese and all other Characters
- Fixed: Chinese characters can now be used in Tags
- Fixed: Quote Builder PHP Error
- Fixed: Bugs in Quote PDF Generation
- Fixed: Quote templates can now be accessed across users
- Fixed: Bug where WP_CLI could not be accessed when "Disable Front-End" setting enabled
- Fixed: Quote search now works again
- Improved: Made transaction search include total value & custom fields
- Improved: Company, Quote, Invoice, Transaction, Task, and Form Searches now (optionally) search custom fields
- Improved: Contact & Company searches now include all address fields
- Improved: Contact & Company searches now include all social profile fields

## 3.0.12 - 2020-03-09

- Fixed: Typo's in Alias DAL
- Fixed: Tasks appearing complete on contact view, when incomplete
- Fixed: PHP notice in migration
- Fixed: PHP Notice for PHP 7.3 users from dompdf library
- Fixed: PHP notice caused by early loading of settings in some instances
- Fixed: Bug where contact tags could not be removed in bulk from v3
- Fixed: Broken link on Bulk action tag creation flow (where no tags existed)
- Fixed: Bug where transaction tag manager wasn't showing up from v3
- Added: Quote & Invoice tags can now be managed in bulk via Bulk Actions from list views
- Added: Ability to clear migration cache via System Status page
- Added: Tasks against companies now show on the company view page
- Added: Task retrieval for companies built into DAL
- Improved: Added notice to tag list view if no tags created yet
- Improved: Tweaked styling of bulk action add/remove tag dialog
- Improved: Updated dompdf
- Improved: Added basic library manager to ZBS Core
- Improved: System Status page now shows version of dompdf in use
- Improved: System Status page now shows InnoDB availability
- Improved: Database creation is now sensitive to availability of InnoDB Storage Engine
- Improved: Changed placeholder values for contact fields to use US defaults & added to translations so these can be localised
- Improved: Custom fields now display full textarea value in Contact Single View vitals box
- Improved: Added support for new dates to v3 Transaction query layer
- Added: Quote & Invoice tags can now be managed in bulk via Bulk Actions from list views
- Added: Tidied up previously created directory "uploads\" (where present)
- Added: Ability to clear migration cache via System Status page
- Added: Tasks against companies now show on the company view page
- Added: Task retrieval for companies built into DAL
- Added: Expanded support for retrieving Alias emails throughout DAL (for WooSync)
- Added: Created .pot file and added placeholder language values so these can be localised
- Added: Support for WordPress.com embedded usage
- Added: If Database creation hits any snags, it'll now expose these directly to the user on the System Status page

## 3.0.11 - 2020-02-04

- Fixed: Portal Access Denied now allows Admin, ZBS Admin
- Fixed: Easy Access Links now allow entry
- Fixed: Invoice PDF now shows correct Hours/Quantity
- Fixed: Timestamps were not respecting localisation on Task Scheduler weekly/daily/list views
- Fixed: Bug in tag saving across all objects where last tag could not be removed
- Fixed: PHP error on multi-site pre v3.0
- Fixed: Contact communication logs now properly update last_updated
- Fixed: Address custom fields of type Date now display properly on the list view & single views
- Fixed: Some indexes were causing MariaDB users table creation to fall over
- Fixed: More viability checks on creation of PDF's
- Added: Export links to top menu
- Added: Internal automator support for log.update
- Improved: Added system check for MySQL Version
- Improved: Added DB Table check to System Status page
- Improved: PDF engine is now switched on by default
- Improved: PDF engine & PDF Fonts now ship with ZBS for greater server compatibility

## 3.0.10 - 2020-01-23

- Fixed: Client Portal sub-page loading doesn't interrupt page loads when no client portal page is set

## 3.0.9 - 2020-01-22

- Fixed: Missed reference causing error

## 3.0.8 - 2020-01-22

- Fixed: Bug which meant link to Quote templates from New Quote page was broken
- Fixed: Allow companies to be added without emails
- Fixed: Mail Delivery 'Delete Method' no longer accidentally deletes the method when you click Cancel
- Fixed: Portal Access Denied if WP user does not have a ZBS contact associated to it
- Fixed: Long Invoice strings cause non-updates
- Fixed: Removed legacy bulk tools data tools button and page
- Fixed: If a task was marked complete, then updated it marked it incomplete
- Fixed: If a null response given to list view builder JS, it now doesn't 'indefinitely load'
- Fixed: Stopped fatal error on edge case of directory change post-install of dompdf
- Fixed: When editing a log the type is now respected in the edit screen
- Fixed: Company names now display properly on the contact list view v3+
- Fixed: Activity logs are now expandable/contractable from the contact view
- Fixed: Exports via Bulk Action Export now not limited to 100 records
- Fixed: Function call which would ignore WPID even though available as a parameter
- Fixed: Invoice customiser now properly saves Hours/Quantity selector choice
- Fixed: Clicking email on Name & Avatar on list view now loads prefilled email UI
- Fixed: WYSIWYG Form button on Classic Editor no longer shows if module is turned off
- Fixed: WYSIWYG Quote template button re-introduced to allow placeholders to be easily inserted
- Fixed: Show on Calendar button not being able to be unchecked
- Improved: Updated PDF templates to use new font set
- Improved: Forced PDF generation to use UTF8 throughout
- Improved: Forced PDF generation to use A4 Portrait throughout
- Improved: Child Pages of the portal now require log in to view
- Improved: Style compatibility tweaks for twenty twenty theme
- Improved: Some Italian translations strings which were translated via machine translation
- Improved: Added core DAL checks for field lengths pre-insert to avoid wpdb errors
- Improved: Field abbreviation layer notifies user field value had to be abbreviated
- Improved: Removed commas when displaying address with line breaks
- Improved: Display Company main email on the View Company page.
- Improved: v3 Migration wizard now catches timeouts and automatically picks itself up
- Improved: v3 Migration wizard now exposes timeouts experienced on the migration report and system status page
- Improved: Removed unnecessary font files to reduce bloat
- Added: New font for PDF generation (supports multiple languages including Cyrillic, Greek, Devanagari, Latin, Vietnamese)
- Added: Migration to automatically install fonts for those users who need them
- Added: System status check of font set install
- Added: Template support for child pages of client portal
- Added: JS Hook for extra invoice functionality

## 3.0.7 - 2020-01-09

- Fixed: Bug where tasks would be disabled if forms were turned off in certain menu modes
- Fixed: Bug where client portal IDs may not have been assigned post v3.0
- Fixed: Bug where by typeahead assignments were no longer saving down
- Fixed: First addition of a contact loads edit which offers ability to view a non-existent contact
- Fixed: Easy-access URLS now work properly for singular quotes
- Fixed: A bug where invoices were not viewable by some contacts via client portal
- Fixed: Ability to search custom fields of contacts from search box
- Fixed: Bug where assignment of event to company wasn't working in some cases
- Fixed: Bug where company assignment easy-view link was incorrectly pointing at contact
- Fixed: Transaction attribute shipping_tax had no label
- Improved: Export wizard now groups field areas (e.g. Main address, Custom Fields)
- Improved: Refactored some variable names for easier code reading
- Added: Custom fields can now be exported along with other fields via Export Wizard

## 3.0.6 - 2019-12-20

- Fixed: Bug where unmigrated v3 users may experience an error with WooSync contact generation
- Improved: Migration routine extension reactivation - further checks

## 3.0.5 - 2019-12-19

- Added: Factory Reset option
- Fixed: Address and assigned to columns now show data properly on contact list view
- Fixed: DAl3 Invoice Ownership bug
- Fixed: php notice in extension manager
- Fixed: php notice in plugin updates
- Fixed: php notice in migrations
- Fixed: CRM dashboard contact column chart over time incorrectly labelled
- Fixed: Bug in data clear reset routine
- Fixed: Migration to fix longstanding bug where some old versions had corrupted the transaction default statuses
- Fixed: Bug where international users were not able to edit custom fields
- Fixed: Quote not accepted/accepted quick filters now work
- Improved: Clarified error codes for Migrations
- Improved: Refined Reset function to properly capture all ZBS data points
- Improved: File deletion now attempts to work around server permissions, and shows message if cannot delete file
- Improved: File deletion error now shows properly
- Improved: Migration version number correction
- Improved: Made default transaction total statuses 'Succeeded,Completed' rather than all statuses

## 3.0.4 - 2019-12-13

- Fixed: DAL2 issue causing some migrations to derail
- Fixed: DAL3 Log Obj issue causing some migrations to derail
- Fixed: Missing language attribute in migrations JS

## 3.0.3 - 2019-12-12

- Added: Task editor -> jump to assigned contact
- Added: Task list to contact view
- Added: Filter for metabox mods for external sources
- Added: Clear Filters button to invoice list view
- Fixed: Date custom fields showing up as timestamps instead of dates on list view & contact view
- Fixed: Broken link (clear filters for quote list view)

## 3.0.2 - 2019-12-09

- Fixed: Bug where by custom fields were not saving for some international users
- Fixed: php notice causing some installs to fall over when producing PDF Invoices
- Fixed: Bug where v3.0 was still showing 'ready for update' on plugins page
- Improved: Allowed Contacts to be added without emails (allow blanks)

## 3.0.1 - 2019-12-06

- Fixed: 3.0 Update message broken link
- Improved: Removed non_blank requirement for contact email address (some users are adding contacts without emails)

## 3.0.0 - 2019-12-06

- Fixed: Bug where contact managers could see but not edit list view columns
- Fixed: Stopped welcome tour firing on homepage
- Fixed: PHP notice on welcome wizard
- Fixed: A default column glitch in the Company list view
- Fixed: PHP Notice in single email
- Fixed: Bug where db reset function was not properly referencing database table names
- Fixed: An edge-case bug where on some webhosts v3 tables were not created due to indexes and dbDelta
- Fixed: Bug where vanilla installs had broken preview links for invoices
- Fixed: Several older migrations were causing php notices on some servers
- Fixed: PHP notice
- Added: DAL3.0 Table migration
- Added: DAL3.0 Generated Object Type class functions (e.g. get, set, meta, tags, etc.)
- Added: Centralised field var storage
- Added: Easy-pay mode for invoices (hash Invoicing)
- Added: Brute force protection for easy-pay invoices
- Added: Migration support for old Metaboxes to new
- Added: DAL3.0 Migration Routine
- Added: From v3.0 Quote Templates can now use Quote Custom Fields (##QUOTE-KEY##)
- Added: Ability to add defaults for fields via field model (DAL3.0+)
- Added: Contact Action: Delete
- Added: Delete verification stage & orphan saving
- Added: DAL error stack and force_unique checks throughout
- Added: Tax rates globally available via settings
- Added: Export v3.0
- Added: Global JS support for new object link generation
- Added: Hashed based Quote Pages on client portal
- Added: Accepted quotes now show accepted date at base of single-quote on client portal
- Added: More efficient retrieval of objects on column-by-column basis
- Added: Error Code Store
- Added: v3.0 Migration Log reporter
- Added: Compatibility fixes for Twenty Nineteen theme
- Added: Compatibility fixes for Twenty Twenty theme
- Added: System status now exposes server locale
- Improved: Wrote new DAL object IO class & subdivided architecture by Object type
- Improved: Moved Companies to Custom Database Architecture (DAL3.0)
- Improved: Moved Quotes to Custom Database Architecture (DAL3.0)
- Improved: Moved Quote templates to Custom Database Architecture (DAL3.0)
- Improved: Moved Invoices to Custom Database Architecture (DAL3.0)
- Improved: Moved Transactions to Custom Database Architecture (DAL3.0)
- Improved: Moved Tasks to Custom Database Architecture (DAL3.0)
- Improved: Moved Forms to Custom Database Architecture (DAL3.0)
- Improved: Added Performance Indexes to Companies (DAL3.0)
- Improved: Added Performance Indexes to Quotes (DAL3.0)
- Improved: Added Performance Indexes to Invoices (DAL3.0)
- Improved: Added Performance Indexes to Transactions (DAL3.0)
- Improved: Added Performance Indexes to Tasks (DAL3.0)
- Improved: Added Performance Indexes to Forms (DAL3.0)
- Improved: Rewrote database creation checks to run from hardtyped array
- Improved: System Status page now shows migration results as labels (not -1 etc.)
- Improved: Removed superfluous event edit code
- Improved: Renamed files for clarity
- Improved: Added backward compatibility to DAL2/3 transition
- Improved: Migrated metaboxes to custom edit screen: Company, Event, Forms, Invoices, Ownership, Quotes, Quote Templates, Transactions
- Improved: V3.0 of Invoicing UI (Improved drawing, tax tables, assignment, styles)
- Improved: V3.0 of Transactions UI separates out JS for performance, & resolves several language leaks
- Improved: All menus now use properly centralised link generation (across DAL versions)
- Improved: All ZBS WordPress menus now centrally controlled
- Improved: Fixed several translation leaks in list view js
- Improved: Moved field global objects to be DB Model driven
- Improved: Moved list view processing into objects DALs
- Improved: Hid empty screen-options drop-downs
- Improved: Can now prefill invoice, transaction, quote from contact or company records
- Improved: Added capacity to send invoices to any email, attach as PDF, and attach associated files
- Improved: Moved all invoice template language from template into translation model
- Improved: All CRM Objects now have generic "get id list" (enabling Export v3.0)
- Improved: Quotes, Invoices, Tasks, Transactions all now have tags via our v3.0 system
- Improved: Squashed tag suggestions which match that already selected for tags
- Improved: Animation of "[object] updated" now hides itself if no outstanding notifications, after sliding up
- Improved: General loading checks for object edit pages
- Improved: Permission checks precursors for object edit pages
- Improved: Foundations for v3.0 API
- Improved: Split Portal into versioned templates (v1, v3) supporting DAL3 portal
- Improved: Non-hashed urls now hide on Invoicing area in client portal, automatically
- Improved: By default, where possible (currently only UK), national tax tables are automatically included
- Improved: Discounts, Shipping & Shipping Tax all now properly display on Client Portal
- Improved: Modified Migrations routine to allow stepped upgrades (resolves some multi-step upgrades on some hosts)
- Improved: Reorganised code surrounding admin settings page to read clearer (and hide transactions menu if not using)
- Improved: Made all custom fields provide a slug for use in templating throughout the CRM

## 2.99.15 - 2019-11-22

- Fixed: PHP admin notice about missing parent menu slug
- Fixed: Empty language string
- Fixed: Checkboxes if more than 65 would error out. Made count dynamic.

## 2.99.14 - 2019-10-31

- Fixed: Bug in listview search

## 2.99.13 - 2019-10-30

- Improved: More proper-escaping of posted data
- Improved: Moved all Forms Styles & Scripts to proper enqueuement & culled some comments

## 2.99.12 - 2019-10-29

- Fixed: Removed assets which were already referenced in WPCore
- Fixed: Task assignment drop down was hidden not allowing users to choose a CRM team member
- Fixed: Alert on delete email if cancelled still deleted
- Fixed: PHP notice on welcome wizard completion
- Improved: Moved before-you-go exit survey to template system
- Improved: Moved welcome wizard to template system
- Improved: Moved Forms to template system
- Improved: Moved remote form functionality to endpoint & stopped forms initiating if extension not activated
- Improved: Compressed unoptimised welcome wizard assets
- Improved: Moved away from internal CURL functions and into WordPress native get functions

## 2.99.11 - 2019-10-23

- Fixed: Made DAL1 objects all order by id descending, instead of date descending, by default
- Improved: Tidied comments
- Improved: Remedied missing subscription code

## 2.99.10 - 2019-10-22

- Fixed: Custom fields unable to change type
- Fixed: Bug where Italian users were unable to select dates in task scheduler
- Fixed: Bug where task scheduler list view wasn't retaining owner-selection across page loads
- Improved: Removed a Mail Campaigns v2 upsell (should have been Advanced Segments)
- Added: Can now (optionally) search contacts based on custom fields

## 2.99.9.10 - 2019-10-16

- Fixed: PHP Notice
- Fixed: PHP Notice for pre-migration 2.7 users
- Fixed: Migration 2.70 bug for some users with zero contacts
- Fixed: Date Format issue for invoice due dates in list view
- Fixed: Date Format issue for invoice date & due date on client portal
- Fixed: Cleartext passwords previously removed, but demo client portal email still had example incorrectly
- Fixed: Custom field types can no longer be altered after creation (stopping type mismatches)
- Fixed: Due dates not properly exposed on single-invoice in portal
- Fixed: PHP Notice for some users on portal
- Fixed: Added default for Client Portal Pro file mode

## 2.99.9.9 - 2019-10-10

- Fixed: Emoji's can now be used safely in Logs
- Fixed: Checkbox custom field type now properly saves for Quotes
- Fixed: Bulk Tagger permissions bug & label errors
- Fixed: Funnels permissions bug
- Fixed: Invoicing Pro permissions bug
- Improved: Strengthened contact edit pages to ensure all fields escaped properly

## 2.99.9.8 - 2019-10-01

- Fixed: Bug where dashboard settings were not saving
- Fixed: Broken references to two images since our CDN address changed
- Improved: Removed legacy telemetry

## 2.99.9.7 - 2019-09-27

- Fixed: Breaking bug in 2.99.9.6

## 2.99.9.6 - 2019-09-27

- Improved: Deploy routine excludes unnecessary files

## 2.99.9.5 - 2019-09-27

- Fixed: PHP Notice caused by outdated tool (removed rebuild titles)

## 2.99.9.4 - 2019-09-12

- Improved: Moved Update API endpoints to new server endpoints
- Improved: Removing Invoicing Pro Settings from CORE (moved into Sync extensions)
- Improved: Removed "Dev Mode" notices from the ZBS admin pages.

## 2.99.9.3 - 2019-09-06

- Improved: Hardened Dash settings AJAX
- Improved: Hardened security around client portal details updates
- Improved: Hardened security around settings pages
- Improved: Hardened permission checks for AJAX methods
- Improved: Hardened security around nonce usage

## 2.99.9.2 - 2019-08-27

- Improved: Refined CRM reset procedure to prevent accidental data deletion from admin.

## 2.99.9.1 - 2019-08-23

- Improved: Data deletion tool admin referrer check to prevent accidental data deletion

## 2.99.9 - 2019-07-23

- Fixed: Custom fields table on contact view now has variable width for those with longer custom field labels
- Fixed: Styles now properly display buttons when hosted on WordPress.com
- Fixed: Stopped welcome tour showing up for non-menu-headed pages
- Improved: Resolved some language usage

## 2.99.8 - 2019-07-02

- Fixed: Bug which meant 0 logs shown on edit page
- Fixed: Multi-line notes now save properly
- Fixed: Client Portal no longer shows links to invoices, quotes, transactions if they're turned off in CORE
- Fixed: Bug which meant email notifications of new invoice didn't have localised currency formatting
- Fixed: Admins can now add segments to quickfilters, even if they don't own the segment
- Improved: Activity on contact "view" page now shows long description
- Improved: v3.0 notice now only shows on ZBS admin pages
- Improved: Tidied the font files stored in html template directory
- Improved: Removed an automatic flush routine which may have been conflicting with Polylang
- Improved: Rewrote Invoicing PDF generation template to use a more wide-support font (Google Noto Latin & Greek)
- Improved: Reduced file size by removing deprecated font (Playfair)
- Improved: Activity log on single view now allows expand/contract of long description
- Improved: Client Portal Pro tools menu now links to settings tab
- Added: Hooks for Client Portal Pro to add to settings page

## 2.99.7 - 2019-06-18

- Fixed: API bug when front end is disabled
- Fixed: Edit contact/obj now won't load for non-existent ID's
- Fixed: View contact/obj now won't load for non-existent ID's
- Fixed: Single email sending now updates "Last Contacted" for contact records
- Fixed: Made new object edit screen hide "view object" by default (as new, nothing to view until saved)
- Improved: Edit Nav now has ID's allowing easier css visibility management
- Improved: Added failsafe to log metaboxes to avoid loading generic list for non-id's
- Improved: Log saving now fires Internal Automator properly (allowing more stable updates for last_contacted against contact objects)
- Added: log.update Internal Automator hook
- Added: V3.0 Preparation notification

## 2.99.6 - 2019-06-13

- Fixed: Second address country showing up when second addresses turned off (at high resolutions)
- Fixed: Bug in CSV Importer Pro relating to company import

## 2.99.5 - 2019-05-29

- Fixed: PHP notice in company view
- Fixed: Case sensitivity in status quickfilter for contact list view
- Improved: White Label CRM system improved

## 2.99.4 - 2019-05-17

- Fixed: Returned Case insensitive search throughout (need to readdress accented character search in later release)
- Fixed: PHP notice if HTTP_REFERRER not set
- Fixed: Invoice Payment buttons now show if WooSync is not active, but Invoicing Pro is.
- Fixed: PHP notice in DAL2.0
- Improved: Support for v5.2+ WordPress
- Added: Support for log-searching queries (ahead of Activity Reporter)
- Added: Address search support for Address Line 1 and City (contact search)

## 2.99.3 - 2019-05-01

- Fixed: Portal Page now shows UK formatted dates correctly
- Fixed: PHP notice when checking rewrite rules
- Fixed: PHP version message now says v5.6 (not v5.4)
- Fixed: Send email slug incorrect when sending from contact view link
- Improved: Client Portal 'Out the box' styles improved
- Improved: Contact tags are now saved on initial save (allowing for more accurate automations tag triggers)
- Added: Contact Form 7 to external sources array
- Added: Filter to allow "Pay Now" button for WooCommerce
- Added: External source post-load hook so new external sources can be added on the fly pre-insert

## 2.99.2 - 2019-04-22

- Fixed: Portal page check fatal error if Portal was disabled
- Fixed: Bug where empty segment title input box disappeared on preview
- Fixed: Bug where segment datetime before/after was not clear
- Fixed: Bug where accented characters were not previewing/generating segments properly
- Fixed: Edge bug where one user was experiencing dupe transactions in UI only
- Fixed: Bug in segment datetime selection for some date formats
- Improved: Datetime pickers now make better sense
- Improved: Better capacity to deal with accented characters globally

## 2.99.1 - 2019-04-18

- Fixed: Bug in previous deploy (Missing file)

## 2.99.0 - 2019-04-18

- Fixed: Bug which caused company logs to show "invalid date"
- Fixed: Home URL instead of Site URL on portal link (emails)
- Fixed: Trying to add a contact with an email that already exists now returns error
- Improved: Activity logs ability to display code snippets
- Added: v3.0 pre-warning message to prep for v3.0 migration

## 2.98.9 - 2019-04-10

- Fixed: Event notifications did not send out
- Fixed: Event notification content was blank
- Fixed: Team page now shows all ZBS CRM user roles
- Fixed: PHP notice on team page
- Fixed: Obscure bug where embedded youtube guide would not display for non Admin roles
- Fixed: Portal PHP notice
- Fixed: Portal template includes and `/clients/` endpoint forced override
- Fixed: Bug where contact edit hook was being fired on every edit page load
- Improved: Fullscreen CSS components
- Added: Reset CRM data functionality to Admin Tools
- Added: New Internal Automator Recipe: "contact.vitals.update"
- Added: New Internal Automator Recipe: "contact.email.update"

## 2.98.8 - 2019-04-01

- Fixed: PHP Memory limit when getting list view pagination counts for transactions and invoices
- Improved: Client Portal now uses portal slug not pagename var
- Improved: Client Portal Pro can now handle page tabs
- Improved: API settings page now has the endpoint clearly stated in the settings tab

## 2.98.7 - 2019-03-27

- Fixed: Select2 library now included as the full.min.js version to avoid conflicts
- Fixed: 4 fringe php notices from portal-fires on our host
- Improved: Activity Log now managed as ZBS Metabox (Contacts and Companies)
- Improved: ZBS Metaboxes now take icon property
- Improved: Switched owner label from link in contact view
- Improved: Now show subscription details on license page
- Added: Core-level performance test routine
- Added: Warning for emails entered as CSV lists

## 2.98.6 - 2019-03-18

- Fixed: Issue where other SMTP plugins were overriding wp_mail in non-standard way, resulting in our text/html workaround causing send artifacts
- Fixed: Proper respect is paid to main email template (previously was mis-linked in settings page) is now _responsivewrap.html & editable
- Fixed: php notice
- Improved: Added better learn menu to settings page
- Improved: Refined main mail template formatting

## 2.98.5 - 2019-03-14

- Fixed: Unnecessary email output in log when sending via SMTP
- Fixed: Generate WP user from Contact View page now works
- Fixed: Awesome Support connector display improved and check for WP user existence
- Improved: PayPal Sync now handles large number of transactions, reports import progress and now allows for local timezones different than GMT.
- Improved: Custom field editor now fully translator friendly & js optimised
- Improved: Added better support for fringe cases e.g. entering no options for custom fields select, radio, checkbox
- Improved: Output of checkboxes and radio buttons now prettier on client portal
- Added: Custom field type: Radio Buttons
- Added: Custom field type: Check Boxes
- Added: Custom field type: Auto Number
- Added: Contact Update & Delete hooks

## 2.98.4 - 2019-03-11

- Fixed: 3 php notices for feedback menu
- Fixed: Centralised logo switch for ZBS / Whitelabel
- Fixed: Bug where segment conditions were not saving
- Fixed: Removed debug code
- Fixed: Improved timeout for local dev override checks
- Fixed: Formatting of datetime on transaction list
- Improved: Removed "New" from mature settings pages, added "Extensions" to settings menu
- Improved: More politely suppressed upgrade messages for users who've already got a CRM Extension
- Improved: Now prompts user to generate API keys when they activate the API
- Improved: Added API docs button to API settings page
- Improved: Client Portal now does not show invoices that are Draft status
- Improved: Removal of "Paid #" on invoice list
- Added: Support functions for Klick-Tipp Connector (imminent release)
- Added: Support for "F j, Y" date format

## 2.98.3 - 2019-03-05

- Fixed: PHP Notice for Whitelabel
- Improved: Updated tested up to value

## 2.98.2 - 2019-03-05

- Fixed: External source icons for CSV importer & Stripe Sync
- Fixed: Leaks in datetime relative to local timezones in List View, Contact Card, Logs, and Human readable dates
- Fixed: Re-added "download Quote as PDF"
- Fixed: WordPress Version number accidental override
- Improved: Trimmed input for Contact AKA Aliases input
- Improved: v2.0 Extension Manager with better support for Whitelabel
- Improved: List view now easier to view all tags
- Improved: Added notice for non-pretty-permalinks & to system status page
- Added: Can now deactivate transactions core extension

## 2.98.1 - 2019-02-27

- Fixed: A bug in SMTP mailer affecting ZBS CRM + AWS SES for mailing out
- Fixed: Style bug on activity log types which are not recognised
- Fixed: Bug in Contact DAL which was stopping custom-fields updating via API given the override blanks setting
- Fixed: Bug where invoices were not correctly being marked as paid (on transaction allocation)
- Improved: Accounted for installs where 'administrator' user role has been removed
- Improved: Halfed loading time for dash page (3.0 perf optimisations)
- Improved: Centralised datetime format overrides & added support for common German date format "j. F Y"
- Improved: Added HTTP Code error catching into licensing
- Improved: Added Licensing Error outputs for better debugging
- Improved: Various style tweaks for Client Portal, including support for TwentyNineteen theme
- Improved: API output for Contacts, Companies, Transactions & Events (now returns ID/Err properly)
- Improved: Added better catch for rebranded update checks (to stop some php notices)
- Improved: Many style tweaks to portal
- Improved: Contact Single View card
- Added: Support for .mp4's showing on Client Portal / uploading generally

## 2.98.0 - 2019-02-18

- Fixed: Hotfix for moment-not-enqueued bug
- Improved: Added better old-version support for catching old PHP activations

## 2.97.9 - 2019-02-15

- Fixed: Double backslash error in asset references
- Fixed: Translation leaks in contact edit fields (placeholders)
- Fixed: Several bugs in locale setup
- Fixed: Bug in Transaction Status setting
- Improved: Centralised repetitive text string as mentioned by @tobifjellner on WP.org support
- Improved: Squashed other plugin notices from impacting our scheduler pages
- Improved: Segment editor now shows "no name" rather than blank in preview for empty-named contacts
- Improved: Updated Fullcalendar.js & Moment.js to latest versions
- Improved: Refined locale js code for exposed js internationalised elements
- Improved: Blocked google chrome typeahead for task date entry
- Improved: Removed Beta messaging where features have now matured

## 2.97.8 - 2019-02-07

- Fixed: Client Portal Quotes now respects the "show on portal" checkbox for "powered by ZBS CRM"
- Fixed: PHP Notice for some edge cases (transactions on dash)
- Fixed: Bug in PDF invoice outputting on portal & generally
- Fixed: Branding leaks on Rebrandr initial install
- Improved: PHP Max Execution time of infinite now displays properly on system status page
- Improved: Single Email UI nows allow more space for typing new emails
- Improved: Contact and Company activity logs now account for creationism & look prettier
- Added: Jump to WordPress User button for admins on contact edit screen
- Added: Client Portal tools to Contact List View

## 2.97.7 - 2019-02-01

- Fixed: Telephone links for contacts & companies now show proper labels
- Fixed: Small bug when inserting contacts with custom fields in addresses
- Fixed: Tweaked fix of external sources rate (300->1k) to affect perf in high-transaction installs
- Fixed: Bug where external sources were not loading properly
- Fixed: If status changed via inline-edit, it properly fires contact.status.update
- Fixed: Bug where companies could not be assigned to ZBS Admin User type
- Fixed: Bug where secondary users could not set screen options
- Improved: Ability to add logs which get lost on creation of new contact (made hide_on_new)
- Improved: Forms filled out when "auto-log contact creation" setting turn off, will now still log any message added
- Improved: Display of gravatars made consistent on contact edit page
- Improved: Added settings link to custom fields tab in contact view

## 2.97.6 - 2019-01-22

- Fixed: Bug where invoice files were not properly deleting
- Fixed: PHP Notice on contact view
- Fixed: Address custom fields now save properly
- Fixed: Made proper telephone icons show for company numbers
- Improved: Added flood-protection for 2.97.5 external source data fix (as one user potentially affected by db over-use)
- Improved: Licensing now has a smarter check for ssl errors, and outputs more helpful messages
- Added: Address custom fields now added everywhere addresses are shown

## 2.97.5 - 2019-01-16

- Fixed: Hotfix for install notice

## 2.97.4 - 2019-01-15

- Fixed: Bug in settings pages, where extension had no settings page
- Fixed: Bug in segments where column view was not correctly populated
- Fixed: Stopped duplication of system email templates occurring
- Fixed: Bug where client portal edit page was outputting portal
- Fixed: PHP notice from licensing
- Fixed: PHP notice for some transactions
- Fixed: Deep DAL bug where external sources had been incorrectly storing
- Added: Migration to fix those installs where system email templates have been duplicated
- Added: Company single view now gets Invoices on Vitals & documents list
- Added: Migration to fix those installs affected by faulty external source recording
- Improved: All reference & item titles now show as bold on list views (Transactions, Invoices, Quotes, Forms)
- Improved: Added proper references for Invoices assigned to companies
- Improved: Reduced strength of font for customer/company assigned names on list view (distracting from ref)
- Improved: External source mapping
- Improved: External source titling now uses proper hooked source
- Improved: Custom fields notification now shows even if empty
- Improved: Replaced "mailto" link in list view with proper ZBS email out link

## 2.97.3 - 2019-01-08

- Fixed: Bug in old DAL re: empty object counts
- Fixed: PHP notice in no-column setups
- Fixed: PHP on some fresh install activations

## 2.97.2 - 2019-01-07

- Fixed: PHP notice left over from licensing
- Fixed: PHP notice in licensing x 2
- Fixed: Licensing nag paging error
- Fixed: Licensing validity error
- Fixed: Licensing now works even if no extensions installed (but only when license key added, it still maintains terms & politeness, will not call home for core if no license key added.)
- Fixed: Ensured County is properly translated in En US & En Aus
- Fixed: Show on Portal now properly respected if Client Portal Pro deactivated
- Fixed: Bug with WordPress Utilities integration
- Improved: Performance improvement to Tagged Contacts, and other db objects from DAL2
- Improved: Made dashboard graph respect specific statuses as set in settings
- Improved: Cleaned up requirement logic
- Added: Growth-over-time graph to dashboard
- Added: Custom Fields contact view tab

## 2.97.1 - 2018-12-21

- Added: Support for custom field auto-population by extensions
- Improved: Added further support for out of date extensions running legacy templates

## 2.97.0 - 2018-12-20

- Fixed: Issue where rebranded versions where showing welcome wizard
- Fixed: Bug in CSV importer lite which was causing extra menu item in Whitelabel CRM
- Added: Licensing & Automatic Updates for extensions
- Added: Simplistic extension detection to system status page
- Added: Support for brand colours & icon in white label crm engine
- Added: Developer Mode (Licensing restricted to production installs)
- Improved: Fixed wording for Generating new WP users (Thanks Omar)
- Improved: Fixed CSV language leaks
- Improved: Fixed CSV white-label leaks

## 2.96.8 - 2018-12-10

- Fixed: Desc typo in portal details template
- Fixed: CSS Bug for some themes on Client Portal (box-sizing)
- Fixed: Issue where rebranded versions where showing welcome wizard
- Added: Support for tag-setting to DAL helpers
- Added: Simplistic extension detection to system status page
- Improved: Made Client Portal Menus Translator-friendly
- Improved: Updated German Formal translations
- Improved: Hushed admin notices for plugin pages
- Improved: Tested to WordPress 5.0
- Improved: Rewrote welcome page
- Improved: Made sure 'id' was not acceptable as custom field key

## 2.96.7 - 2018-11-23

- Fixed: Debug removed from team page
- Fixed: Made "do not show footer" more respectful
- Fixed: Removed 404 to calendar pro
- Fixed: Bug where Segments were 'per user' strict by default
- Fixed: Bug where system email template test for reset password was not sending
- Added: Check for correct SQL permissions to System Status page
- Added: Some checks to improve reliability of saving companies against contacts
- Improved: System Status page now shows warnings emphasised
- Improved: Tweaked wording for blank-overwrite setting [Thanks Omar]
- Improved: Separated 'powered by' setting between forms & portal, made respectful throughout, and removed quotes powered by
- Improved: Added better security to email templates pages
- Improved: Shows message when contact has no email (on quote builder), rather than letting email a quote to no-address
- Improved: Added block to stop user being able to add custom fields which are already base fields

## 2.96.6 - 2018-11-16

- Fixed: Glitch where by uploads\ directory was being created for pdf inv gen
- Fixed: Made it so you CAN unset company/contact on invoice
- Fixed: Made it so you CAN unset company/contact on quote
- Fixed: Bug in segments where compiled-contact-count wasn't being properly calculated
- Fixed: Can now add all tags via bulk actions -> contact (not just non-empties)
- Fixed: Mail Delivery tests now work with modern tlds (.website etc.)
- Fixed: 2 Language leaks in list view
- Fixed: Returned 'clear filters' to list view
- Improved: Improved some SQL which was non-direct for getContacts DAL funcs
- Improved: Add Semantic WP workaround for animated buttons
- Improved: ZBS Team retrieve functions
- Improved: Added better calendar support (for Calendar Pro extension)
- Improved: Support for those disabling the CORE before extensions
- Improved: Updated Sweet Alerts to 7.29
- Improved: Removed branding link & refined email for rebranded versions (mail delivery test)
- Added: Business Telephone number to Business Info settings
- Added: PDF Statement Generation
- Added: Extra info (for statements) setting
- Added: PDF Statement send to contact (via email attachment)
- Added: Quick Nav - from invoice part payment to transaction
- Added: Quick Nav - from transactions to assigned invoice
- Added: Quick Nav - from transactions to assigned contact
- Added: Quick Nav - from transactions to assigned company
- Added: Quick Nav - from transactions learn menu to contact & company
- Added: Quick Nav - from invoice learn menu to contact & company
- Added: Quick Nav - from quote learn menu to contact & company

## 2.96.5 - 2018-11-07

- Improved: Added class attributes to contact view
- Added: Guide: How to Map CSV Importer Fields
- Added: Guide: Can I map Custom Fields with CSV Importer?
- Added: NL Dutch Translation (Thanks Cees)
- Added: Up-to-date formal German translations (Thanks Alvaro)

## 2.96.4 - 2018-10-30

- Fixed: Bug in last version re: new template for pw reset (fixed)
- Fixed: Mail Campaigns v2 beta support
- Added: Support for menu filtering via Extensions directly

## 2.96.3 - 2018-10-25

- Fixed: Avatar image bug in gravatar mode on contact view
- Fixed: Bug in list views on empty later pages
- Fixed: Language leak in settings page (affecting Italian)
- Fixed: Bug in invoice transaction auto-marking-paid logic causing php notice
- Improved: HTML template for client portal creation
- Improved: Added null check for large int prettifier
- Improved: Made quote system permissions more robust (to try to remedy occasional bug 'cannot access page')
- Added: Support for js hooks for list view types
- Added: Client Portal Password Reset via Contact Edit page
- Added: Client Portal Password Reset email template

## 2.96.2 - 2018-10-19

- Fixed: PHP Notices in format helpers and advanced segments
- Fixed: PHP Version notice now much smarter
- Fixed: Duplicate Welcome Wizard code removed
- Fixed: Bug in addUpdate Contact where custom fields passed in Limited Fields were not updating
- Fixed: Send Email now properly logs the Email history for new installs
- Fixed: System Emails Pro (private beta) - formatting preserved
- Fixed: WooSync - Updating admin side order details (address or email) also updates contact
- Fixed: PHP Notice in Email system
- Fixed: Send Email now properly jumps to 'sent' after email sent
- Fixed: Send Email now allows properly for special characters in subject
- Fixed: Contact labels on Company view now show properly again
- Improved: Stripe Sync - Transaction ID check strengthened so to not cause duplicate transactions
- Improved: Quote HTML templates & formatting will now save more reliably in-format
- Added: WooSync - Updating My Account billing address now updates ZBS contact billing address (same site)
- Added: WooSync - Updating My Account Name and Email now updates ZBS contact (same site)
- Added: WooSync - Extra Info to My Account showing extra ZBS info (custom fields from ZBS)
- Added: WooSync - Setting to show extra info in my account (and fields to exclude)
- Added: System Emails Pro: subject line added
- Added: Contact List View: Company Column (Thank you for dev support Carlos)

## 2.96.1 - 2018-10-11

- Fixed: Removed Settings Tabs for extensions with no settings
- Fixed: Twilio Connect scripts re-included on edit page
- Fixed: Give WP now uses first status for transaction default
- Fixed: WooSync Welcome Wizard returned
- Fixed: Client Portal Pro now hides the tabs you tell it to
- Fixed: MailChimp now gets all lists (not limited to 10)
- Fixed: Bug where enabling Quotes extension was error 500'ing
- Fixed: Bug where date-time range pickers were not working in segments
- Fixed: Tag manager add visual glitch
- Added: Support for contact avatar sizing and classes (Mail Campaigns v2 Prep)
- Added: Support to centralised link func for sending out contact email
- Improved: Added visual icon for DNM (Do not disturb-mail) flag
- Improved: Removed global wp footer 'thanks' (was legacy bs), added helpful link to remaining
- Improved: Made "Upgrade contact database" message even more prevalent
- Improved: Added message capacity to list views
- Improved: Adding tag when empty list (via tag manager) now works

## 2.96.0 - 2018-10-05

- Fixed: Send Test Invoice now sending fully again
- Fixed: PHP notice on login screen
- Fixed: Glitch with WooCommerce & Auto-generating portal users which was badly assigning ownership
- Fixed: Sending multipart emails now works fully for wp_mail and SMTP modes
- Added: Beta Feedback support (ahead of Mail Campaigns v2)
- Added: Support for autologging from extensions (ahead of Mail Campaigns v2)
- Added: Proper login_hook to client portal login
- Added: Support to our mail functions for better attachments
- Added: Support for meaningful attachment names (only in SMTP delivery methods)
- Improved: Brought Segments DAL into line with DAL2 prepare
- Improved: CSS Styles to Portal Login
- Improved: CSS Styles to Portal Update Details page (Thanks Alvaro!)
- Improved: Quotes & Invoices can now be emailed with/without their attached files

## 2.95.7 - 2018-09-28

- Fixed: Hotfix for welcome tour getting 'stuck on'

## 2.95.6 - 2018-09-27

- Fixed: PHP leak in invoice builder
- Fixed: Restarting welcome tour now really does restart it reliably
- Improved: Advanced Segments updated to v1.2
- Improved: Welcome tour much more reliable now

## 2.95.5 - 2018-09-24

- Fixed: PHP notice on edit files
- Added: Acceptable upload file formats: jpeg & gif
- Added: Support for Client Portal Pro feature: PDF Thumbnail generation
- Added: Support for Client Portal Pro feature: Image Thumbnail generation
- Added: Support for Client Portal Pro feature: File Categories

## 2.95.4 - 2018-09-21

- Added: New Extension: Advanced Segments
- Added: Mail Delivery method support for mismatching SSL certificates (shared hosting)
- Improved: Updated extensions to match up to date list

## 2.95.3 - 2018-09-17

- Fixed: Bug in list view javascript for inline-editing
- Fixed: Removed welcome tour icon
- Fixed: Bug where user screen options where saving incorrectly
- Fixed: Borked url when 'create new' segment (on empty)
- Fixed: Bug where invoice emails were not sent if portal off
- Fixed: Invoice URLs for client portal emails
- Fixed: Bug where invoices sent to companies didn't have company address
- Fixed: Invoicing Pro CSS miss-reference
- Improved: Hid second address more globally when turned off in settings
- Improved: Added send error dialog when error sending invoice
- Improved: Mails sent out for invoices when not using portal
- Improved: Moved Invoice builder js translations
- Improved: Hooked enqueument for portal
- Improved: Dirty-checks (when editing contact) now work smoothly in Firefox
- Improved: Made text input semantic ui style in edit generic field wrapper
- Improved: Edit 2.0 now faithfully uses format helper for field gen
- Improved: Date custom fields now display datepicker automatically
- Improved: Each user can now set the 'records per page' screen option on list views
- Improved: Rest API for typeahead queries
- Improved: All assign-to-contact/company typeaheads now query actively
- Improved: Invoices assigned to companies now auto-load email from company

## 2.95.2 - 2018-09-14

- Fixed: Bug where our thanks footer-message was blanking out existing message
- Fixed: Bug where people were getting wrongly redirected
- Fixed: Bug in Rest API retrieval of company/contact lists
- Fixed: Several out-of-format dates in PDF invoices
- Added: Cron Manager (Preperation for Mail Campaigns v2)
- Added: Cron schedule (5mins)
- Added: Preparations for single email scheduling
- Added: Message support for plain permalink users
- Added: 'Assigned To' column to Quotes, Invoices, Transactions (Gets wp user assigned to contact owner of obj)
- Added: Setting: Use Beta feature (inline editing on list views)
- Added: Simplified Owner List retrieval
- Added: Ability to inline-edit Contact Status + Assignment
- Added: Advanced Segments (Beta) Extension (Contact Fields)

## 2.95.1 - 2018-09-06

- Fixed: Email Scripts now properly include minified version

## 2.95.0 - 2018-09-05

- Fixed: Returned Portal.php back to 2.94 version (pre-attempted-fixes-which-broke-links)
- Fixed: Rebrandr leak in testing email & one in Events
- Fixed: Emptied faulty German translations
- Added: New Internal Automator hook: Task Update
- Added: New user roles & permissions for sending emails to contacts
- Added: Starred email threads
- Added: Typeahead send single email
- Added: Delivery method choice for single email to contact
- Added: Email thread recording
- Added: Email thread sidebar (including tasks, $total value etc.)
- Added: Edit contact link from Email Thread
- Added: Delete email from contact email thread
- Added: Made all default fields available as columns from column manager
- Added: Made all custom fields available as columns from column manager
- Added: Ability to show/hide sidebar in Company List View
- Added: Ability to show/hide sidebar in Quote List View
- Added: Ability to show/hide sidebar in Invoice List View
- Added: Ability to show/hide sidebar in Form List View
- Added: Column Manager for Company List View
- Added: Column Manager for Quote List View
- Added: Column Manager for Invoice List View
- Added: Column Manager for Form List View
- Improved: Email send system UI
- Improved: Threaded email send system
- Improved: Brought List View Columns all into localisation model (language)
- Improved: Added field groupings to List View Column Manager
- Improved: Added Address1/2 split to Column Manager
- Improved: Made all field columns sortable for Contact List View
- Improved: Made Column manager properly permission-based
- Improved: Add Drop Target for easier Column management
- Improved: Made Column Manager Mods PHP5 Safe
- Improved: Increased (savable) number of custom fields from 64 to 128
- Improved: Business select for (assign contact/transaction/invoice to) now much more performant

## 2.94.2 - 2018-08-31

- Fixed: PHP notice on contact view
- Fixed: Bug in logs which was stopping proper deletion
- Fixed: PHP notice in fields for a specific custom field config
- Fixed: PHP notice in Quotes with empty dates on Client portal
- Fixed: PHP notice on White-label task list
- Fixed: Setting 'Extra Info' in Invoice Builder settings now saves properly
- Added: Permissions: AddEdit Log, Delete Log
- Added: Migration to rebuild user roles
- Added: Screen options to all list views - records per page
- Improved: List View Column manager optimised for easy view on all screen sizes
- Improved: Log system now only lets admins delete logs
- Improved: Company & Customer typeaheads now run from properly formed WP REST API endpoint
- Improved: When in 'no-avatar' mode, contacts names are used against owner-companies
- Improved: Better support for PHP5.5 (fixed an activation glitch)
- Improved: Added full debug for Mail Delivery method setup
- Improved: Mail Delivery SMTP outbound now verified source

## 2.94.1 - 2018-08-24

- Fixed: PHP notices for some settings configurations in Client Portal
- Fixed: Australian translation had become corrupted, replaced
- Fixed: Persistent Style bug
- Added: Task list (per user)
- Added: Link to privacy policy in readme (better accessibility)
- Improved: Mobile-responsiveness for screen options
- Improved: Removed several branded references (for rebrandr)
- Improved: Task edit
- Improved: Task assign to contact &/or company
- Improved: Task show/hide on calendar
- Improved: Task complete/incomplete

## 2.94.0 - 2018-08-18

- Improved: Update checks system vastly improved

## 2.93.2 - 2018-08-16

- Fixed: Bug where transactions assigned to companies didn't display customer in list view
- Fixed: Bug via unescaped translation leak in list views
- Fixed: Bug where forms were not displaying in drop down list in WYSIWYG editor (posts, pages)
- Fixed: Bug in invoices & transactions where dates shifting back a day on some timezone setups
- Fixed: Php Warning illegal offset string
- Added: Class-based support for list view model
- Added: Support for future-only datetime pickers
- Added: Ability to set screen options for transactions table on company view
- Added: Server Timezone exposed on System Status page
- Improved: Made Transaction ID's clickable in Transaction list view
- Improved: Add new re-added to Contact edit UI
- Improved: Added time-since-adding to dash contact list
- CRM Features page released

## 2.93.1 - 2018-08-10

- Fixed: Bug whereby contact list view was not properly sorting by last name
- Fixed: Bug whereby portal tab permalinks not auto-flushing
- Fixed: Bug where internal automator & autologging not firing for new invoice
- Fixed: Invoice Assign
- Fixed: Rebrandr bug
- Fixed: UI bug with settings page
- Fixed: Bug in Uploading new Quote Files (Duplicates)
- Fixed: Last Contacted was not automatically updating in DAL2
- Added: Ability to enable/disable email powered by attribution
- Added: Datetime picker to js (for Mail Campaigns)
- Added: Ability to change label for 'Second Address'
- Added: Feature to automatically mark invoice as paid when transactions allocated for full amount
- Added: New custom field types: Numeric Decimal, Numeric (to all custom fields)
- Improved: Mail templating engine
- Improved: Mail Unsubscribe settings
- Improved: Made datetime functions for time as well as dates via zeroBSCRM_date_i18n_plusTime
- Improved: Made it impossible to enter wrong CSV format for settings like funnel status

## 2.93.0 - 2018-08-02

- Fixed: Bug where invoices & quotes played up when Portal disabled
- Fixed: Removed debug code in core
- Added: Demo Data generating function for test emails (Mail Campaigns)
- Added: Text Fallback support for SMTP outbound mail
- Improved: Learn Menus centralised
- Improved: Learn Menus prepped for developer overrides for Resellers
- Improved: Added automatic mail-server specific info-links for Mail Delivery setup
- Improved: Better Rebrandr coverage

## 2.92.0 - 2018-07-30

- Fixed: Bug where transaction assigned to contact couldn't be unassigned via UI
- Fixed: Bug where contact name was showing as -1 when no contact assigned to transaction
- Added: Support for removing submenus
- Added: First cut of material admin tweaks
- Improved: Removed need for customer on transaction add integration func
- Improved: Added Companies as possible transaction assignees in transaction view

## 2.91.0 - 2018-07-27

- Fixed: PHP Warning for those jumping large versions (e.g. 1.2 -> 2.90)
- Fixed: Glitch with learn menu on quote template page
- Fixed: Preview link on invoice
- Fixed: Few php warnings squashed
- Fixed: Latest Log column labels
- Added: Transactions Custom Fields
- Added: Transactions can now be assigned to companies
- Added: Transactions now show up on company view
- Added: Transactions total now shows up on company view Vitals
- Added: Transactions columns to Company List View
- Added: Support for do-not-email setting (unsubscribe support)
- Added: DAL for unsubscribe setting
- Added: Showed do-not-email flag on contact view
- Added: Showed do-not-email flag on send email
- Added: Improved Preview Segments to support MC2 Feature
- Added: UI Helper: label
- Added: Company File Attachments
- Added: Company File Editor
- Added: Function to return wp user email
- Improved: Centralised edit field output + Genericifed
- Improved: Tweaked styles on Transaction edit for better view
- Improved: Removed over-branding on contact send email
- Improved: Extension support to avoid errors when deactivating pre-core

## 2.90.0 - 2018-07-20

- Fixed: Bug in new window code caused when pop-up suppressed by chrome
- Fixed: Mistyped label id
- Fixed: Bug in PDF invoicing for Companies
- Fixed: Formatting not carrying through into email for single-contact emails
- Fixed: PHP notice in Portal.php
- Fixed: PHP notices on portal invoices
- Improved: Default email template styles
- Improved: Centralised Business info collection into a new settings page 'Business Info'
- Added: Hook for ZBS Extensions to add menu items via WP system
- Added: Returned 'temphash' work into DAL (removed in error, needed for Mail Campaigns)
- Added: Business Social account setup
- Added: Setting for Unsubscribe message
- Added: Support for shortcode-based unsubscribe page
- Added: Quote Template now takes into account all customer fields (and custom fields)
- Added: "Add Log" quick action for contacts

## 2.89.0 - 2018-07-10

- Fixed: PHP Notice on fresh install dash
- Added: Optionally retrieve settings from db as well as cache when using getSetting
- Added: Zero BS CRM API Connector
- Added: Client Portal ability to recreate required page(s)
- Added: Support for Client Portal Pro Templating
- Added: Full Client Portal PRO integration
- Added: Client Portal Pro: Client Files
- Added: Client Portal Pro: Client Task Scheduler
- Added: Client Portal Pro: Client Invoice PDFs
- Added: Client Portal Pro: Customise colours (menu bg and text colour), and template
- Added: Client Portal Pro: Customise slugs, labels, icons
- Added: Client Portal Pro: Turn each client area on or off (e.g. invoices or files)
- Added: Client Portal Pro: Add to Calendar (Task scheduler)
- Added: Client Portal: Now automatically logs against clients when THEY change details
- Improved: Migration logging system & output of complete/incomplete migrations
- Improved: Client Portal now uses shortcodes!
- Improved: Client Portal login now captures fails and redirects properly
- Improved: 20+ small tweaks, documentation improvements to Client Portal and Client Portal Pro

## 2.88.0 - 2018-07-06

- Fixed: Broken link on dashboard
- Fixed: DateTime parsing bug
- Fixed: PHP Notice on Invoice Builder
- Added: Segments Bulk action: Delete
- Added: Guide to Dynamic Segments
- Added: Guide to Segment Quickfilters
- Improved: Segments hook-ins now allow class-based addition of arguments & conditions
- Improved: Segments slug corrected
- Improved: Segments list view formalised into normalised class
- Improved: Added first layer of support for multi-line fields in CSV importer

## 2.87.0 - 2018-06-29

- Fixed: Complex bug in SQL Where builder
- Fixed: Bug in Bulk Tools -> Delete where contacts weren't being deleted
- Fixed: Sticky sidebar now lets you scroll through tags (list view)
- Added: CRM Segments (List, Edit, New)
- Added: Segment Condition: Status (Equals, Not Equal, Contains)
- Added: Segment Condition: Full name (Equals, Not Equal, Contains)
- Added: Segment Condition: Email (Equals, Not Equal, Contains)
- Added: Segment Condition: Date Added (Before, After, in Date Range)
- Added: Segment Condition: Date Last Contacted (Before, After, in Date Range)
- Added: Segment Condition: Has Tag
- Added: Segment Condition: Is not Tagged
- Added: Segment Condition: Quote Count (Equals, Not Equal, Less than, More than, in Range)
- Added: Segment Condition: Invoice Count (Equals, Not Equal, Less than, More than, in Range)
- Added: Segment Condition: Transaction Count (Equals, Not Equal, Less than, More than, in Range)
- Added: Segment Condition: Country (Equals, Not Equal)
- Added: Segment Condition: County/State (Equals, Not Equal)
- Added: Segment Condition: Postcode/Zip code (Equals, Not Equal)
- Added: Segment type helpers (Tags, Statuses, Dates)
- Added: Segment compiling & auto-compilation (performance gains for EXTRA LARGE CRM databases)
- Added: Internal Automator Action: contact.update
- Added: Internal Automator Actions (name support) contact.update, contact.new, contact.status.update
- Added: Ability to use Segments as Contact Listview Quickfilters (setting in Custom Fields settings)
- Added: Ability to use segment Quickfilters alongside other search/tag functionality
- Improved: Added methods to DAL2 getContacts (by status, without status, is not tagged, contacted before, contacted after, has email, in county, in country, in postcode)
- Improved: Mobile Responsive styles for list view
- Improved: Mobile menu now includes tools
- Improved: DAL1 status functions
- Improved: Refactored Segment DAL Code

## 2.86.0 - 2018-06-22

- Fixed: Prefill details for Contact -> Add Invoice
- Fixed: Three UK date reference PHP Warnings
- Fixed: Permissions error for 'Manage Transactions' and CSV Importer PRO
- Fixed: Date picker locale transactions issues
- Fixed: Navigating many pages of contacts via tags now maintains tag selection
- Improved: Added extra clauses to DAL2 contact retrieval
- Improved: Mobile CSS styles for mid-range mobiles
- Improved: Empty name contacts now show email in place of name where using avatar icon function
- Improved: Increased tag suggestion count 15->25
- Added: Clients can now change their password from the Client Portal
- Added: UK + US 1and1 SMTP settings for quick-fill Mail Delivery Setup Wizard
- Added Guide: Using Zero BS CRM with AWS SES for Email Delivery

## 2.85.0 - 2018-06-15

- Fixed: Bug where some invoice dates where showing up as 01/01/1970 (after last update)

## 2.84.0 - 2018-06-13

- Fixed: Show email instead of blank name in email history
- Fixed: Issue with occasional format leaking in French ($9900 for $99)
- Fixed: Months now translated on company record
- Fixed: DAL2 Contacts now show on menu properly
- Fixed: Client portal shows address info properly & allows update
- Fixed: Brought CPT menus inline with new translation key
- Fixed: Transactions menu giving sorry no access when in non english
- Fixed: Portal Title issues when other plugins filter pre_get_document_title
- Fixed: Admin now sees extra tools
- Fixed: Invalid date issue with our datepickers and the date format 'jS F Y'
- Fixed: Pages such as edit contact now have proper page titles
- Added: Expanded zbs var to encapsulate our common url parameters
- Added: Saving protection (if you edit any field in Contact, but try to leave without saving, it'll prompt you)
- Improved: Made JS Format currency function in-line with international formatting

## 2.83.0 - 2018-05-31

- Fixed: Your Details tab not saving (Client Portal)
- Fixed: Transaction date picker
- Fixed: Making date formats global
- Fixed: Manage Invoice List formatting Bug
- Fixed: 2 Log editing functionality bugs
- Fixed: Invalid date on Invoices
- Added: Delete Tags from Tag Manager
- Added: 'Suggested Tags' quickfinder
- Added: Hook to allow extra meta to be stored against Invoice
- Improved: Notes now only let you edit 1 at a time (UI Improved)
- Improved: Notes of an unknown type now do not allow edits
- Improved: DAL2 delete tags now deletes tag links (cleaner database)

## 2.82.0 - 2018-05-29

- Fixed: 2 bugs with dupe ID's
- Fixed: Hook in contact view wasn't using proper object
- Fixed: API Groove Bug
- Fixed: Duplicate hook in Portal code
- Added: Hook for working with ZBS Extension: Client Password Manager
- Improved: Hook for actions for contacts
- Improved: Hook for log type overrides

## 2.81.0 - 2018-05-24

- Fixed: Bug in API sticky statuses where sticky status was not honoured
- Fixed: Bug in build meta function (contacts)
- Fixed: Bug causing contacts to be updated with empty fields (if updated via api/forms)
- Fixed: PHP warning for core file
- Fixed: Bug where meta not deleting in DAL2
- Fixed: Bug where meta reinserting not deleting
- Fixed: PHP notice in events list
- Fixed: Bug in contact ownership model
- Fixed: Style bug for some users on contact view
- Fixed: Bug in settings model relating to character '
- Fixed: ' bug in mail templates, contact fields, DAL2 generally
- Fixed: Bug where by transaction statuses were not automatically created on install
- Fixed: Date formatting on all date & date-range pickers now respects locale setting
- Fixed: Faulty merge routine for bulk actions (contacts) since DAL2
- Fixed: When merging, tag references were orphaned, no longer
- Added: Support for include checks (Stripe in extensions)
- Added: Double force the second address box to hide on setting (for some users it was showing empty)
- Added: 'Files' tab to contact view
- Added: Show/Hide files on Client portal (if using Client Portal Pro)
- Added: Ability to delete files from Contact View
- Added: Ability to give files titles & descriptions
- Added: File Edit view
- Added: Mail Delivery guides to settings page
- Added: Migration to auto-update user roles
- Added: Option to allow/disallow API/forms to override data with blanks
- Documentation: Added full guides on Mail Delivery Methods via SMTP and wp_mail
- Improved: Added upload_files permissions to customer manager user role
- Improved: File display on contact record
- Improved: Refactored file assoc storage
- Improved: When deleting files, if they were in a slot, that'll now be cleared
- Improved: UI now reflects files against contact live (e.g. removed slot, deleted) in Contact Edit
- Improved: Adjusted Invoice Notification emails based on feedback (logo fixes)
- Improved: Clarified SMS button in contact editor
- Improved: Added hard refresh mode for settings loading
- Improved: AKA/Alias area now validates email pre-add

## 2.80.0 - 2018-05-16

- Fixed: ' in custom fields causing output glitches
- Fixed: Price & Date custom field types sometimes not saving down
- Fixed: AKA input now clears when adding a new alias
- Fixed: Typo Gravatars
- Fixed: Name column now sorts properly for contacts
- Fixed: Form ID column now links to form
- Fixed: Bug where some sort orders would result in empty data lists
- Improved: Updated Form list default columns to include 'title' and 'edit'
- Improved: Mobile CSS and responsiveness
- Improved: Hid empty ID for new contact edit
- Improved: Sorting on Contact List View now works on first name and last name
- Improved: Warning now shown if you try to update a contact with an already existing email address
- Improved: Get Contact function now checks Alias (AKA) as well as normal email
- Added: 2 actions to Portal: zbs_portal_nav_pre_logout & zbs_portal_request
- Added: Telephone numbers to search on contacts list view

## 2.79.1 - 2018-05-14

- Fixed: Paging bug in new DAL (Contacts)
- Fixed: Small bug in portal generation code
- Fixed: Collation type bug in update routine
- Fixed: Style bug in PDF Invoices
- Improved: All timestamps now take into account timezone offsets properly
- Improved: Contact search is now FAR more reliable
- Improved: Reordered some logic & tweaked date building funcs
- Improved: Customer API Request updated to DAL2 methods
- Added: ₣ symbol for XPF currency
- Added: Sticky sidebars to list views
- Added: Local/Connectivity checks to system status page
- Added: Local Time logging to System Status page
- Added: System Email recent history logging
- Added: System Email open tracking
- Added: Option to globally enable/disable system email open tracking
- Added: Mail Template editor & Basic templates for:
- Added: Option to choose format of send direct email name (e.g. John Doe @ Your Company)
- Mail Template: Welcome to the Client Portal
- Mail Template: Event Notification
- Mail Template: Invoice Notification
- Mail Template: Quote Notification
- Mail Template: Quote accepted Notification
- Added: Mail Delivery setup (Support for SMTP & wp_mail for all outbound emails)

## 2.79.0 - 2018-05-03

- Fixed: Bug for translated dates in Company List & Edit Contact
- Fixed: Some html errors as advised by Mélanie
- Update to translation files and translation support to match plugin slug (zero-bs-crm)

## 2.78.0 - 2018-05-01

- Fixed: Backward compatibility for PHP 5 bug

## 2.77.0 - 2018-05-01

- Fixed: Bug in tag manager causing some new tags not to save
- Fixed: Bug where new users would hit issues with extension settings saving
- Fixed: Typo 'Activity Log'
- Fixed: Removed a title fixing function that was causing some installs trouble
- Fixed: Rounded avatars in edit view
- Added: Capabilities to ZBS Metabox engine
- Added: Initial capabilities for each metabox (on contact edit)
- Added: Ability to hide/show metaboxes
- Added: Ability to minimise/show metaboxes
- Added: Page Layout panel
- Added: Per-user screen options (via Page Layout + metabox dragdrop)
- Improved: Tag Manager is now object generic, prep for finish of DAL2 work
- Improved: Updated main plugin Author URL to https://zerobscrm.com
- Improved: Exposed Custom Field Keys (Slugs) + slightly improved UI
- Improved: Added backward compatibility & slug compatibility to Contact Form 7 Extension
- Improved: Moved edit page metabox system inline with pageKey setup (Screen Options / Page Layout)
- Updated: Semantic UI Icon Set

## 2.76.0 - 2018-04-25

- Fixed: PHP Notice in cron
- Fixed: Bug in pre-upgrade users - > dashboard
- Fixed: Bug in DAL2 get Tags in specific cases
- Fixed: Bug where lack of iconv php module would stop migration working
- Fixed: Bug in form WYSIWYG insert icon for some post types
- Improved: Made '23 items' type specific & translatable, e.g. '23 contacts', '1 contact'
- Improved: Caught a few more language leaks
- Improved: Wrote our own prepare func to avoid wpdb prepare notice leaks
- Improved: Formalised labels for dashboard activity

## 2.75.0 - 2018-04-23

- Fixed: Recent activity on ZBS Dashboard
- Fixed: Bug in internal automator (not firing for new contacts)
- Fixed: Invoicing 'To' data not displaying properly on PDF files
- Fixed: PDF Invoices not working correctly with Greek characters
- Fixed: Zero BS CRM Customer Manager Role could see all menus
- Fixed: Bug in custom field editor when no custom fields present
- Fixed: Bug in tagging which created dupes (owned by different users) (Turned off ownership for tags)
- Migration: Removes duplicate tags created by ownership bug, re-linking any contacts to a singular tag
- Improved: Made styles properly conditionally enqueued
- Improved: Added more checks to overcome a php notice occasionally seen if invoice details half-filled
- Improved: Rebrandr Whitelabel improvements
- Improved: Slightly rearranged settings for improved readability
- Improved: WP Semantic conflict styling fix for right-aligned buttons
- Added: (Optional) Prev Next skipping through contacts
- Compatibility: Added support for Material Admin v3.5+

## 2.74.0 - 2018-04-20

- Hotfix: Transactions duplication bug fix for WooSync and PayPalSync
- Fixed: Extra checks for custom field unpacking
- Fixed: Integrations AddorUpdateTransaction - bug fix
- Fixed: Integration functions bug
- Fixed: Bug where some CSV exports would show a warning when loading in Excel (SYLK file warning)
- Fixed: Bug where merging 2 contacts would break the date on that contact
- Added: Company name to contact vitals (in b2b mode)

## 2.73.0 - 2018-04-19

- Added: Function for csv importer 1.5 compatibility
- Improved: Several DAL2 functions relating to add/update tag objects
- Improved: Customisable tabs via code - added content via function passthrough
- Several fixes for supporting CSV IMPORTER PRO

## 2.72.0 - 2018-04-18

- Fixed: PHP notice on some versions when activating
- Fixed: Bug in export tools where contact details were passing as blank
- Fixed: Bug in export contacts where contact details were passing as blank
- Fixed: Bug in contact bulk action: Merge Contacts
- Fixed: Bug in saving logs against a contact
- Fixed: Language labels being put out without adding slashes, causing bugs for some translations
- Fixed: Tag links on contact view
- Improved: Tidied naming for addedit page functions
- Improved: Made Styling for view pages generic
- Added: Beginnings of company action hooks
- Added: Company View Page
- Added: Company list view column: View Company (as well as Edit Company)
- Updated: zeroBS_customerSecondAddr to work with DAL2
- Launched: ZBS CRM Code Examples
- Guide: Adding Custom Contact Tabs with Code

## 2.71.0 - 2018-04-15

- Fixed: Bug in translations where County/State was incorrectly displayed
- Fixed: Bug causing Company Logs not to display
- Fixed: Added back in Custom File slots for contacts
- Fixed: Bug where contact meta could not be saved as empty
- Fixed: Bug where you could not delete contact files
- Fixed: PHP Notice for deleting non-existing store files
- Fixed: Bug where multiple custom file boxes saving at once would dupe files
- Fixed: Bug in Client Portal User Generation
- Fixed: Bug where deleting objects (transactions, quotes, etc.) would send to error page (bought into new paging)
- Improved: Added error messages to auto-migrations from zero-contact installs
- Improved: Contact Client portal generation button wording
- Added: 24 hour timestamp to activity log on contact view

## 2.70.0 - 2018-04-14

- Added: DB Hook for database builds from within extensions
- Added: System Admin Log (For CRM Admins)
- Added: Began adding generic DB prep for DBv2
- Added: Temporary hashing to DB formally (for secure out-in preview pages etc.)
- Added: Automatic garbage control for temporary hashes
- Added: Improved DAL functions for getting tags
- Added: Segment edit page
- Added: Segment edit page JS
- Added: Slug generation
- Added: Custom Edit page
- Added: Forked Metaboxes to our own classes
- Added: Avatar option - Gravatar or Custom Images or None + integrated into single views + list views
- Added: Notifications system for page saves etc.
- Added: Social acc (basics, Twitter, Facebook, LinkedIn) to contact default object
- Added: "Older than X" quickfilter to contacts (DB2+)
- Added: Log Authors to Dashboard etc. (Thanks Troy for Diff files)
- Added: Semantic helper in JS for percentage bars
- Added: Contact Log msg for fresh feeds
- Added: List Custom Fields for Contacts (Added to Contact List View)
- Added: Core CRM version to system status page
- Added: Permissions model for Mail Manager
- Added: Ability to hook in to Contact View Vitals tabs
- Added: Support for API create_contact/customer - can now use id as well as email
- Added: Made Transactions link to transaction edit (on Contact View)
- Fixed: Improved List view JS so as it does not falsely load where it shouldn't
- Fixed: Bug in Notifyme js
- Fixed: Style glitch in social accounts metabox
- Fixed: Language translation of date-time format string
- Fixed: Bug in Transaction contact allocation
- Fixed: Bug in pagination for invoices & forms
- Fixed: Bug when hiding Quotes/Invoices on Contact View (shows right tab now)
- Fixed: Bug where currency change was not saved down (from CRM Welcome Wizard) [Thanks Brian]
- Fixed: Bug in exposing addresses
- Fixed: PHP Notice in Dashboard
- Fixed: Bug in dashboard sales funnel rendering
- Fixed: Export contacts borked in DB2
- Fixed: Bug in address custom fields not automatically adding themselves to field sorts
- Fixed: Some PHP notices in Invoice Builder (Thanks Diego)
- Improved: Added cachebuster to contact typeahead data pull
- Improved: Segmentation DB tables
- Improved: Genericified Tags metabox, ahead of db2 global rollout
- Improved: Routed all links to contacts via centralised function
- Improved: Added default image for contacts globally (when using custom image mode)
- Improved: ZBS centralised links to allow for slugs
- Improved: API endpoint create_contact/customer now works with custom fields and id in DB2+ versions
- Improved: Country names are now available for translation
- Improved: Contact Search now returns original record if AKA (Alias) is added + searched
- DB2: Wrote Initial Tables for Contacts, Tags, Custom Fields
- DB2: Wrote globalising functions for site, team, ownership
- DB2: Wrote first fix CRUD functions for Tags, Tag Stats
- DB2: Improved argument autoloading: Made multi-dimensional (for insert/update fields)
- DB2: Improved contact search (Speed, field coverage)
- DB2: Added Object Meta storage (all obj types)
- DB2: Added External Sources
- DB2: Added Web Traffic Tracking (e.g. GA UTM's)
- DB2: Added Close-out routine to avoid edit-migration errors
- DB2: Added Logs
- DB2: Wrote Migration routine
- DB2: Added Migration routine notifications
- DB2: Moved DAL into Centralised $zbs var
- This update covers a major DB2 Update & Mail Campaigns v2 prep

## 2.63.0 - 2018-04-01

- Fixed: PHP warning in Zero BS CRM Dashboard
- Fixed: JS warning on Zero BS CRM Dashboard page
- Fixed: Added protection against auto-draft's showing up in typeahead assignments
- Fixed: Bug in contact edit which would show php notice on unassigned record
- Fixed: WordPress login logo override working (again)
- Fixed: Bug where 'Disabled Front End' would create a looping redirect
- Added: On uninstall, all Zero BS Roles are fully removed
- Added: (Optional) Powered by Zero BS login link
- Improved: Hid "assigned to X" from contact intro sentence, when Assignment turned off
- Improved: If using 'Assignment' and no user is assigned to a contact, any Customer Manager can edit them

## 2.62.0 - 2018-03-30

- Added: Link/Tab to customer page via filter
- Fixed: Bug where additional file boxes would not save always
- Fixed: Revenue on dashboard goes weird at end of the month
- Improved: Reworded 'Other files' to 'Contact Files'
- Improved: Page check function now catches posted data
- Improved: Forced inclusion of columns for 'edit invoice' and 'edit quote' where these were somehow lost in translation
- Improved: Added support for WordPress.org translations proper (3rd Attempt)

## 2.61.0 - 2018-03-23

- Added: File 'slots' (custom contact file boxes)
- Added: Customizable Dash
- Added: German Human Translation
- Added: Filter to the PDF invoice title so it can be modified
- Added: Turkish Lira in currency list
- Added: Quote to PDF download
- Fixed: Timezone incorrect on dash
- Fixed: Funky funnel & backwards labels
- Fixed: PayPal Sync compatibility errors (php notices)
- Fixed: Client Portal now works with Plain permalinks (i.e. ?p=)
- Fixed: Invoice PHP notice
- Fixed: Default columns not working for invoices & quotes
- Improved: Removed hard-typed slugs
- Improved: Initial Invoices
- Improved: Nonces to export functions
- Improved: Client portal welcome emails - no linebreaks
- Improved: Transactions now support prefill

## 2.54.0 - 2018-03-14

- Fixed: Bug where multi-tabs were closing each other in contact single view
- Fixed: PHP notice where no social details on contact single view
- Fixed: Basic CSV Export now works even with unset fields
- Fixed: Typo in column editor
- Fixed: Bug where removing contacts column from company list view removed the option to re-add it
- Fixed: Contacts column not working for company list view
- Added: Basic CSV Export now exports contact ID
- Added: Advanced CSV Export now exports Contact ID, Company ID
- Improved: Invoice PDF files are now stored with correct invoice ID (not post ID)
- Improved: Removed iframe embedded feedback form (flagged some peoples security plugins up) - replaced with image

## 2.53.1 - 2018-03-09

- Improved: List views all now have correct edit button options for columns
- Improved: Consistency fix for "Calendar" => "Task Scheduler"
- Improved: Contact Singular view (Added Addresses to Contact Vitals)
- Improved: Contact Singular view (Added Telephone numbers, including Click2Call support)
- Improved: Contact Singular view (Added Social accounts)
- Improved: Contact list (etc.) now properly display appropriate avatars (or gravatars)
- Improved: Migrated “One or more of your ZBS CRM extension need updating.” into notifications system + rejuvenated connect page
- Fixed: Bug in Transaction Total calculation
- Fixed: Bug in listview JS (Fix for Mary)
- Fixed: Bug in currency display on Contact Vitals
- Fixed: Invoicing now pre-fills with contact details appropriately
- Fixed: Contacts saying 'works for...address'

## 2.52.0 - 2018-02-25

- Fixed: Invoice Status Box recovered
- Fixed: Deprecated user info replaced
- Fixed: Client Portal "Your Details" now updates data
- Fixed: Fix to saving contact if owned but unable to change ownership
- Fixed: $$ double currency showing up on those servers with PHPIntl installed
- Fixed: Localisation bug where language labels where breaking list views
- Added: Log out tab on the Client Portal Navigation
- Added: Forgot Password Link on Client Portal Login Page
- Improved: Language leak moved into _e

## 2.51.2 - 2018-02-20

- Fixed: Reseller Integration fixes
- Improved: Language Integrations: de_DE, en_AU, es_ES, fa_IR, fr_CA, fr_FR, it_IT, nb_NO, nl_NL, nn_NO, pt_BR, ro_RO

## 2.51.1 - 2018-02-17

- Fixed: Multi-site bug on permissions check for client portal

## 2.51.0 - 2018-02-16

- Added: Support for wp filters in contact, quote, invoices, transactions menus
- Added: Support for extension header bars
- Added: Support for extension sub top menu bars
- Fixed: Bug in client portal redirection

## 2.50.3 - 2018-02-15

- Fix: Removed debug output

## 2.50.2 - 2018-02-15

- Fix: Fix for list view warnings
- Fix: For admin_init/init ordering

## 2.50.1 - 2018-02-15

- Hotfix: Legacy support for extensions pre v2.0

## 2.50.0 - 2018-02-13

- Added: New List views for Transactions
- Added: zeroBS_getAllContactsForOwner to get the contact list for owner
- Added: Transaction status to transaction edit page
- Added: Transaction status to transaction add new page
- Added: Learn button to the contacts list page
- Added: Learn modal for contact list to explain and point to adding field + why totals differ
- Added: Transaction settings page (to control which transaction statuses are included in total)
- Added: New Transaction now added to Activity Log of the contact
- Added: Zero BS CRM External Sources detail added (for further "source" tagging)
- Added: Your Zero BS CRM Team page to show you your CRM members at a glance
- Added: System notifications and Notifications UI
- Added: Learn buttons throughout new UI
- Added: Zero BS CRM Welcome Tour
- Added: Forms new list view UI
- Added: Quotes new list view UI
- Added: Company List view now has automatic status quick filters
- Added: Generic support for new list view to automagically render fields like edit links, ID, etc.
- Added: Accepted / Not Accepted quick filters to Quote list view
- Added: Bulk actions to Companies list: Add Tag, Remove Tag, Delete Company
- Added: Bulk actions to Quote list: Accept/Unaccept, Delete Quote
- Added: Bulk actions to Invoice list: Change Status (Draft, Unpaid, Paid, Overdue), Delete Invoice
- Added: Quickfilters for Quotes: Accepted, Unaccepted
- Added: Quickfilters for Invoices: Draft, Unpaid, Paid, Overdue
- Added: Bulk actions to Forms List: Delete
- Filter: zbs_settings_tabs filter (to add new tabs to settings page)
- Filter: zbs_approved_external_sources (to allow extensions to register an approved source)
- Added: Migration routine for 2.40
- Added: Custom Trash for Quote Templates
- Added: New method for storing External Source data, and a migration routine to move over old data
- Added: Centralised method for accessing contact "Actions"
- Added: Contact Actions drop-down list for single contact view
- Updated: Semantic UI JS to 2.2.14
- Added: Functions for 'section' detection (e.g. is contact area)
- Added: Contact Column: "Last Contacted" (checks against 'Call' and 'Email' type logs)
- Updated: PDFDom to 0.8.2 + wrote migration to update everyone
- Added: "Not Contacted in X Days" Quickfilter (for contacts & companies)
- Added: Note types to company: Call/Email
- Added: Administrator tools to System Status page (+ Rebuild User Roles action button)
- Added: Sticky Statuses (in API create.customer)
- Improved: Extended search parameters for Contacts (searching all meta)
- Improved: Contacts list now uses date formatting
- Improved: Zero BS Class added to tidy up load order (performance improvement)
- Improved: Funnel refinements to list icon order (R to L) instead of (L to R)
- Improved: Added class for deny network activation (v3.0 prep)
- Improved: Add or Update Customer now checks whether an earlier event should bring forward when the contact was created
- Improved: Removed dependency on bootstrap for ZeroBSCRM.CustomerSearch.php
- Improved: Centralised new list view (Classified)
- Improved UI: Additional helper UI buttons and improved list view header bar
- Improved UI: "Show All" UI for customer tags when lots of tags are added
- Improved UI: Long tag names now truncated with ..
- Improved UI: New "View Contact" UI page added for overview
- Improved UI: Tidied Dashboard Recent Activity
- Improved: Migration messages and other labels properly into translate-able
- Improved UI: List views all now have clear filters, clear filter descriptive sentences
- Improved UI: Column editor button now shows "open" state
- Improved: Integrated Semantic UI into our global styles
- Improved: Made labels out of plain text labels in Task Scheduler -> Options
- Improved: Removed legacy code from custom views & custom view settings
- Improved: Modified settings pages to be easier to use
- Improved: Restricted welcome tour to admins only
- Improved: New column more reliable: Last Contacted
- Improved: Moved auto-download extensions store onto AWS CDN (improves speed + reliability)
- Improved: UI message clarity on list view error find
- Improved: Hid WP Top bar for front-end client portal users
- Improved: Post/Page WYSIWYG Form inserter catches no-forms situation elegantly
- Improved: Hid usual WP menu <
- Fixed: Client Portal was not showing clients quotes or invoices
- Fixed: Client Portal Page titles now uses document_title_parts not wp_tile
- Fixed: Transactions "Assigned to" was showing blank when only customerID was set
- Fixed: Total Transactions was showing up blank on customer list view
- Fixed: CSS improved for contact list view where long emails split the line
- Fixed: Status Change check was checking for incorrect meta value
- Fixed: Added 'admin_zerobs_usr' capability to Administrator role
- Fixed: Contact Avatars breaking size
- Fixed: Visual bug in name/avatar ellipsis overflow
- Fixed: Bug in list view where view footer was inflated despite no bulk actions
- Fixed: Bug in Form embed
- Fixed: Bug in new transaction editor, and added back in default statuses for those who didn't get automatically set
- Fixed: Bug in permissions letting strict users see post categories
- Fixed: Bug in activation
- Fixed: Bug where zbs admin couldn't see a few bits: Forms, Quote templates
- Fixed: Bug where ZBS quote manager could not create new quote templates (and improved all roles to properly use create_posts)
- Fixed: Bug in load order affecting customer portal
- Fixed: PHP Notices on Invoice Single on customer portal
- Fixed: Bug in transaction settings
- Fixed: Bug in quote & inv list views which meant ID was not in-line with zbsid
- Fixed: Bug in header menus causing edit/add to be duped
- Fixed: Forced Autocomplete (Google Chrome) to disable for all applicable fields (was interfering with new ver. chrome)
- Fixed: Bug in export contacts when status empty
- Fixed: Bug in dash when contacts meta empty
- Fixed: Bug which was causing WYSIWYG buttons to disappear for quote template editor and page/post editor
- Fixed: Bug where assigning customers wasn't working on Transactions
- Fixed: Access issue where Zero BS Customer role could see WP Admin (now redirects to client portal or home if not using portal)
- Fixed: Form shortcode output fix
- Fixed: Proposal accepted email gen fix
- Languages: Added French (fr_FR) Translation (human translated)
- Languages: Added Slovenia (sl_SL) pre-translation (machine translated)
- Languages: Added Turkish (tr_TR) pre-translation (machine translated)
- Languages: Added Norwegian (nn_NO) pre-translation (machine translated)
- Languages: Added Norwegian (nb_NO) pre-translation (machine translated)

## 2.28 - 2018-01-24

- Improved: Language now reads "Contact" instead of "Customer" in custom fields settings page
- Fixed: Can now have up to 64 custom fields (if really need that many!)

## 2.27.1 - 2017-01-13

- Fixed: Hotfix for older PHP versions (<5.6)

## 2.27.0 - 2017-01-12

- Added: First name and Last name to contact list view
- Fixed: Several API bugs (from API v2)

## 2.26.3 - 2017-01-05

- Fixed: Bug in Company Create API

## 2.26.2 - 2017-01-05

- API: Create Customer added "assign to"
- API: List Customers, filtered by owner
- API: List Customers, added additional options (per page, page, owned by)
- API: Customer Search. Modified for search by email
- API: Added ability to connect to Groove HQ (store your GROOVE API in GROOVE_API_TOKEN defined var)
- API: Create Company (including assign to)
- API: List Companies, filtered by owner
- API: List Events (filterable by user)
- API: Create / Update Event (start_date, end_date, crm_user, customerID, notes)
- Added: B2B Mode label 'Domain' (Janos)
- Added: Automatic Linkifying for text fields on Company and Contact records!

## 2.26.1 - 2017-12-27

- Fixed: Bug in Client Portal Settings
- Fixed: Bug in Client Portal re: Customer ID

## 2.26.0 - 2017-12-04

- Added: Ability to specify custom statuses for Companies (distinctly from Customers)

## 2.25.0 - 2017-12-04

- Fix for DAL companies retrieval
- Typo fix for settings page

## 2.24.0 - 2017-12-02

- Fixed: Bug in task scheduler which forced assignment of an task event to a contact (not able to select none) (Thanks Gibby)
- Fixed: Typos in company meta boxes
- Improved: Made functions to allow extraMeta values for contact object
- Improved: Several improvements to functions in DAL relating to ownership and complex data retrieval
- Added: "In Country" selector to DAL get Companies function

## 2.23.0 - 2017-11-26

- Fixed: Bug in 2.22 which caused notice on some installs when adding new contact (Thanks Markus)
- Fixed: Bug in JS which was not properly permifying log types
- Added: (Optional) Automatic Logging of customer/contact status change
- Added: Auto-logging of client portal creation log (against customer)
- Added: Ability to add secondary role to client portal users
- Added: Internal Automator access actions for Client Portal user creation
- Added: Ability to select specific "status" types for users to get access (only) - all users who get status changes to other user types get accounts disabled :)
- Added: Dirty/Clean input logging :)
- Added: Automatic enable/disable of client portal access on status change
- Improved: Refined code around client portal user creation
- Improved: Moved automatic client portal creation into Internal Automator
- Improved: Created Settings page SaSS
- Updated: Font Awesome updated to 4.7.0

## 2.22.0 - 2017-11-25

- Fixed: Bug in contact title rebuild routine, (Thanks Markus)
- Fixed: Removed erroneous debug code

## 2.21.0 - 2017-11-24

- Added: Log type "Feedback" to contact/customer
- Added: Disable/Enable Customer Portal User
- Added: Action hooks in preparation for Invoice Itemiser (requires invoicing pro)
- Added: SMS button for "Send SMS" if mobile number is entered (requires Twilio extension)
- Added: Customer Edit scripts function added (for JS running on customer edit)
- Added: Action to hook in additional scripts to customer edit page
- Fixed: Bug in invoice builder which would show warning if status was draft
- Fixed: Bug in Rewrite engine causing a notification
- Fixed: "Add New" was breaking across line on Events and Quotes
- Improved: Standardised AJAX responses via function
- Improved: Invoice UI now auto-populates the email based on Customer select
- Improved: Address to: Contact or Company now changes the email to: depending on which choice
- New Extension: Twilio Extension available from this version of ZBS CRM Core onwards :-)

## 2.20.0 - 2017-11-21

- Added: Bulk Actions to list view model
- Added: Customer bulk action: Delete
- Added: Customer bulk action: Add Tag(s)
- Added: Customer bulk action: Remove Tag(s)
- Added: Social Accounts (optionally) logged against each contact
- Added: Sanity check on bulk-delete
- Added: Capacity to remove/keep orphaned elements under a customer (e.g. invoices etc.)
- Added: Permissions model for Mail Manager
- Added: Mail Delivery settings page
- Added: SMTP Setup Wizard (Mail Delivery) preemptively for Mail Campaigns and generally better email integration
- Added: Included php-encryption for (slightly) safer SMTP detail storage
- Added: Test & Remove options for SMTP Delivery Methods
- Added: Segments - basic segmentation tool for ZBS CRM (Custom list view, creator and DB)
- Added: Several helper funcs to better prepare for DB2 + refine DAL
- Added: Ownership model to task scheduler/events (and view "specific users" timetables if admin)
- Fixed: Several address view bugs in Contacts & Companies to do with countries and show/hide second address
- Fixed: Added several UI overrides for default WP styles (Improve UI settings pages, fix .card icons, add noborder segment)
- Fixed: Typo in Client Portal dialog (Thanks Curt)
- Fixed: Bug in feedback button for Contact list view
- Fixed: Bug in list view tables when in compacted view
- Fixed: Bug which would stop you being able to remove Company from contact
- Improved: Moved Settings page CSS into it's own SASS
- Improved: Centralised some UI elements & their CSS
- Improved: Migrated Customer/Contact list view into generic list view for reuse
- Migrated: Write migration routine for 2.4, including new Segments tables
- Updated SweetAlerts to v2.0 (7.4)
- Improved: Made Tags hide in list view, if no customer tags (yet)
- Improved: Performance tweaks for task scheduler
- Improved: Footer thank you message space
- Improved: Important CSS & JS now auto-clear-cache when new version installed
- Updated SweetAlerts to v2.0
- Mail Campaigns v2 prep

## 2.18.0 - 2017-11-14

- Added: "Address to" option when in B2B mode for invoices (choose company or contact)
- Added: Currency localisation formatting in list views
- Added: Function in DAL to get assigned owner (different to post creator)
- Added: Additional Functions to DAL for getting customer mobile (in preparation for Twilio extension)
- Added: API can now process customer tags $customer['tags'] = array('tag1', 'tag2');
- Added: Product updates to this changelog :)
- Improved: Made forms always select a default style (Improved UI flow)
- Improved: CSV Importer Lite now logs & gives details of duplicate entries (overwritten)
- Improved: Upgraded to sweet alert 2 (in preparation for Automations and Mail Campaigns v2.0)
- Improved: Added alignment for customer / company address on the invoice to PDF
- Improved: Assign to Customer and Assign to Company for invoices now use type-ahead
- Improved: Removed the open in a new window behaviour of view all customers from dash
- Improved: Settings UI alignment polished
- Improved: Settings tab added for Gravity Forms Extension to allow forms to post to separate ZBS CRM install
- Improved: Logs CSS changed from green to subtle grey (matching WP admin background)
- Improved: Welcome Wizard links to new checkout and wording tweaks
- Fixed: Bug which causes invoices to save as publish when they were auto draft
- Fixed: Bug in Quotes which caused a fatal error when sending test emails
- Fixed: Bug in Quotes which meant customer email was not being populated
- Fixed: New transaction hook would cause an infinite loop if updateLog was called from the hook
- Fixed: Hide Countries was not hiding countries from the list
- Fixed: Second Address was still showing Country is "Hide Second Address" was ticked
- Fixed: Bug which meant the welcome wizard fired at every activation
- Fixed: License tab (temporarily removed) due to new account area
- Fixed: Admin notice disabled asking to connect account
- Fixed: Bug in logs that was allowing addition of locked type logs (programmatic options)
- Extension: Gravity Forms now has settings to send forms to externally hosted ZBS CRM (using API)

## 2.17.0 - 2017-10-24

- Added: (Optional) Automatic Status Quick-filters

## 2.16.1~.6 - 2017-10-18

- Fixed: Role / Permissions model now properly installs/resets as per updates
- Fixed: Bug in client portal (dashboard link)

## 2.16.0 - 2017-10-12

- Fixed: Bug causing company names to save as blank
- Fixed: PDF invoice was showing ,,,, if no Address
- Fixed: PDF invoice layout was skewed if P&P and Tax was shown
- Fixed: Add/Edit Business Details link was not loading invoice settings tab
- Fixed: Bug that was showing "Country" twice in Field Sorts
- Fixed: Quote URL in email quote was not directing to the client portal
- Fixed: Bug that was stopping transaction.new Internal Automator firing
- Fixed: Client Portal invoice was showing the wrong INV# in payment reference
- Fixed: Client Portal Invoice CSS improved for tall logos
- Fixed: Client Portal PHP warnings and notices
- Fixed: Assign to (throughout) now includes Zero BS Admin Roles
- Improved: Ownership renamed to "Assignment" to better reflect the intention of a team CRM
- Improved: Client Portal now has a settings tab
- Improved: Client Portal Welcome email can be customised in settings
- Improved: New Contacts added to your CRM can automatically be granted Portal Access
- Improved: Quote Notification email can now be customised in settings
- Improved: More prep for reseller integration
- Added: Migration routine to correctly update all company names
- Added: UI messages to highlight custom fields, field sorts
- Added: zbs_new_transaction action hook (for automations preparation)
- Added: Function to create portal access from contactID

## 2.15.0 - 2017-10-07

- Fixed: Bug in "Address line 3" (which should be ) "City"
- Integrations: Prepared Core for Reseller CRM Integration
- Improved: Centralised admin page slugs more globally
- Improved: Removed debug logs
- Added Languages: Spanish, Aus, Brazilian Portuguese

## 2.14.2 - 2017-09-26

- Fixed: Client Portal UI New Bug

## 2.14.1 - 2017-09-26

- Fixed: Client Portal UI Bug
- Added: Prep for Zero BS CRM Automations (Workflows)
- Improved: Automatic Extension update awareness, usage, and notifications
- Improved: Update notifications now dismissible

## 2.14.0 - 2017-09-19

- Fixed: Hot fix for bug in customer filters which affected Mail Campaigns
- Fixed: Bug in DAL breaking default statuses
- Fixed: Missing CSV Importer (Lite) link for slimline menus
- Fixed: Bug in Quote Acceptance (Client Portal)
- Extension: Added Resume functionality to CSV Importer
- Added: "Max Execution Time" to system status
- Added: "Max Upload File Size" to system status
- Added: "Max Post File Size" to system status
- Added: "WordPress Max Upload File Size" to system status
- Added: "Memory Limit" to system status
- Improvement: "Company" assignment now a typeahead box, rather than a select (Performance Improvement)
- Full translation completed: Zero BS CRM has been fully processed for WordPress style translations

## 2.13.0 - 2017-09-07

- Added: System status check - upload directory for asset store
- Added: Precursor to private file systems for CRM users - file hashing
- Added: File Store management to Invoice & Quote uploads
- Added: New translations for Portuguese & Spanish
- Improved: Extensions manager updated with latest extensions
- Improved: Extension manager connect only for users with paid extensions
- Improved: ZBS Customer uploads now get stored in managed directory
- Improved: Slight refactor of existing file display code
- Fixed: Bug in list views which caused visual glitch for ZBS Admin users
- Fixed: Bug in Transactions user permissions (affecting ZBS User Groups)
- Fixed: Typo bug in AdminPages.php
- Fixed: CSV Importer feature integrated into Data tools screen (CSV Tagger)
- Tweaked: Extensions manager styling & Help urls
- Updated: Admin Global CSS

## 2.12.1 - 2017-08-24

- Added: Skype Calling (Click to call option)
- Added: Up-to-date Spanish CRM Transalations
- Added: Improved an improved Install Extensions helper
- Fixed: API bug where default status wasn't always auto-populating
- Fixed: Bug in Events causing times to save down incorrectly
- Improved: List view when customer has no name, now displays email (if present) as clickable edit link

## 2.12.0 - 2017-08-18

- Added: CRM Dashboard now shows key metrics
- Added: Funnels to track status distribution
- Added: CRM Dashboard shows funnel visualisation
- Added: CRM Dashboard shows revenue progress
- Added: CRM Dashboard shows Recent Activity
- Added: CRM Dashboard shows 10 Latest Contacts (Lead, Customer, etc)
- Added: WooCommerce disable admin blocking for ZBS roles
- Added: Improved anonymised feedback system
- Fixed: Forward compatibility issues with PHP7.0 (Global variable variables) [Thanks to Trlogga for identifying]
- Fixed: Allow translation of "Main Address" and other localised field labels
- Fixed: Field naming not clear in API (Country was taking mixed (ISO country code & full country name)) (temporary fix)
- Fixed: Zero BS CRM TinyMCE link suggestions in post content removed
- Updated: Included Zip library to allow PHP7.0 support
- Updated: Language library files to include latest labels
- Improved: Made Customer List View sidebar Toggle
- Improved: Made Customer List View table allow scrolling (temporary fix)
- Improved: Slimline Menu items expanded for extensions
- Improved: Invoice Export now includes Company Name (if present)
- Improved: Settings UI improved to make settings page tidier

## 2.11.1 - 2017-08-14

- Improved: Improved default column selection for new Customer List View
- Fixed: Made Customer Name link to edit customer in new Customer List View
- Fixed: Bug in company selection from Customer record in B2B
- Fixed: Bug in company list view (in DAL)

## 2.11.0 - 2017-08-11

- Added: Awesome new customer views (Customisable Columns, filters etc.)
- Added: Semantic UI for custom views
- Added: Per-user customer ownership/assignment (on/off via settings)
- Added: Per-user company ownership/assignment (on/off via settings)
- Added: Access restrictions based on ownership
- Added: Helpers to DAL for ownership/assignment of elements (Customers, Companies etc.)
- Added: Columns to Customer List View: Assigned to, Latest Log, Tagged, Edit Link, Has Invoices, Has Quotes, Phone Link
- Added: Telephone PBX Clickable links to Customer Record (Mike Martin suggestion)
- Added: Return key search
- Added: Clear filters button to list view
- Added: Pagination (including search filters maintained & now Quick Filters)
- Fixed: Bug in External Sources metabox not properly hiding for CPTs
- Fixed: Bug in new customer addition (php warning on all error installs)
- Fixed: Bug in CRM from 2.10.3 (Custom fields not present)
- Fixed: Bug in drag-drop Quick Filters to empty lists
- Fixed: Bug in welcome wizard which was auto-enabling "Override for all WordPress users setting"
- Fixed: Moved Quotations to Client Portal
- Improved: Slight performance tweaks for getCustomers main DAL function, relating to quotes
- Improved: List view filters now show in sentence format
- Improved: Made filters maintain search setup when "deep"
- Delayed: More Complex Quick Filters in future version

## 2.10.7 - 2017-07-25

- Fixed: Removed the Calendar Tab functionality
- Fixed: Added "Events" to the ZBS Navigation Dashboard
- Fixed: Made the ZBS Navigation Dashboard Mobile Responsive
- Fixed: Bug which was causing an error in certain situations
- Fixed: PHP Notices squished

## 2.10.6 - 2017-07-21

- Added: Beta Calendar functionality
- Added: Internal Automator recipe for new event
- Added: Auto-logging for new event
- Added: Support for Give to ZBS CRM
- Fixed: Warning bugs in Calendar, slimline menu etc.

## 2.10.5 - 2017-07-12

- Fix for ver 2.10.4 minor bug

## 2.10.4 - 2017-07-12

- Added: Support for ConvertKit CRM Sync
- Added: From and To on PDF Invoices to show customer information
- Added: do_action for new customer creation added (do_action('zbs_new_customer'))
- Added: do_action prep for other objects
- Added: *BETA* feature: Advanced Search (Activity/Customers)
- Fixed: Bug in Invoice Tax calculation when discount was applied
- Fixed: Contact Form 7 settings tab removed if extension active (no settings needed)
- Fixed: Support links point to knowledgebase

## 2.10.3 - 2017-06-22

- Added: Show/Hide option for customer ID (beginnings of improving customer fields + UI)
- Added: Show/Hide option for all non-essential customer & company fields
- Added: Company ID show/hide option
- Fixed: Bug in notes stopping new note saves
- Fixed: ZBS Head link redirect
- Fixed: CSS Bleeding on users page
- Fixed: Invoice Add button hidden on some pages for specific user groups
- Improved: Client Portal UI improvements - tabs don't look so ugly!

## 2.10.2 - 2017-06-10

- Fixed: Bug in PHP Short-tags issue in Admin Pages

## 2.10.1 - 2017-06-10

- Fixed: Bug in activation for some hosts (Thanks for reporting Jeff & Christian)

## 2.10.0 - 2017-06-07

- Added: Pre-cursor for API "add log"
- Added: Ability to specify "default status" for new (uncategorised) customer additions
- Fixed: Link to invoice settings in invoice builder
- Fixed: Reference to invoices in label on custom fields settings
- Fixed: Permalink flush now fired on quote builder install
- Fixed: Fixed bug causing warning on Quotes manager page
- Fixed: Bug in Invoice number incrementing
- Fixed: Bug in "Override WordPress Users" affecting client portal & API
- Fixed: Bug in "Disable Front End" affecting client portal & API
- Improved: Labels relating to disabling front end & effects on portal etc.
- Improved: Updated Extensions page to reflect new extensions (WorldPay Sync, Stripe Sync, Google Contacts Sync, Groove Sync, Contact Form 7 Sync)
- Improved: Added log date setting

## 2.0.7 - 2017-05-31

- Added: Action hook zbs_new_customer for when a new customer is added in the admin panel
- Fixed: hash_equals warning message removed
- Fixed: Changing email doesn't lose the link to the WordPress user ID in the Client Portal
- Fixed: Login link in Customer Portal
- Fixed: Sync tools will now correctly show up when menu in 'slimline' mode
- Fixed: styles issue when working with Mail Campaigns
- Improved: Send Test Invoice now displayed below the invoice
- Improved: Alerts on Invoice page now use the Sweet Alert modal
- Added: Pre-requisites for StripeSync
- Updated readme file to include up to date blog features and customer reviews

## 2.0.6 - 2017-05-24

- Added: Prerequisites for WorldPay Integration (WorldPay Sync)
- Added: Improved support for localisation (added US to begin)
- Added: Locale check to System Status
- Fixed: Bug in PDF Invoicing which would show PDF engine installed when it wasn't
- Fixed: Client Portal Quote Title
- Fixed: Client Portal Quote links
- Improved: Improved explanation for WP Override mode and re-arranged options page so as is easier to see

## 2.0.5 - 2017-05-16

- Urgent fix: Post title error fix (bug in 2.0.4)

## 2.0.4 - 2017-05-12

- Added: Quotes, Transactions and Details page to the Client Portal
- Fixed: Bug in quote builder not allowing you to use blank template
- Fixed: Removal of special characters in Quote hashes
- Fixed: Invoice ID was outputting when invoicing pro recurring invoices was disabled
- Fixed: Bug where Select a Company was blank
- Fixed: Bug which was showing date added as 1/1/1970 on Customer Search
- Fixed: Date formatting for Customer Lists, Contact Lists, Quote Lists
- Fixed: Date format now applying for Transactions List
- Fixed: Quote and Invoice Offsets now applying to 'Add New'
- Fixed: Bug causing the Quote ID to increment on 'Save' and 'Update'
- Fixed: Quotes now only accessible through the Client Portal
- Fixed: Bug where email subscriptions from welcome wizard were not always automatically applied
- Improved: Upped default log paging to 100 per load
- Improved: Attachments meta box now lower priority on the invoices page

## 2.0.3 - 2017-05-05

- Re-ordered Zero BS CRM Menu for ease of use
- Combined two welcome/home pages into one more-useful page
- Fixed: Bug in Welcome Wizard (Subscriptions)
- Improved: Welcome Wizard improvements generally

## 2.0.2 - 2017-04-29

- Added: Compatibility for Invoicing Pro: Recurring billing via Stripe/PayPal
- Added: Readme updated with several CRM reviews

## 2.0.1 - 2017-04-18

- Added: PHP Version shown on System Status page
- Fixed: Security vulnerabilities (Thank you Timothy Jacobs of ironbounddesigns.com)
- Improved: Menu item "Extensions" was redirecting to the CRM Extensions Store when it should have pointed to the internal extension manager

## 2.0.0 - 2017-04-07

- Added: Zero BS CRM API!
- Improved: Welcome Wizard - added Entrepreneurs bundle option
- Improved: Sured up API security
- Improved: API Endpoint exposed & API Secret generation added
- Fixed: Readme file
- Fixed: API DB Inclusion
- Tweak: Invoices displayed - now shows 100 by default
- CRM Wide Improvements & Performance tweaks

## 1.5.0 - 2017-03-16

- Added: Customer Portal (Let Customers sign in, view invoices, and pay for them with Invoicing PRO)
- Added: FREE CSV Importer (Lite Version of CSV Importer Extension)
- Added: Date and Time format support (uses WordPress settings)
- Added: Integrated throughout (Date and Time format's properly)
- Added: Proper translation prep, throughout
- Added: Initial translations: English (UK), English (US)
- Added: WHLang Lib support (all useful labels overridable from ZBS CRM admin settings)
- Added: Integration prep for Invoicing PRO (PayPal Payments)
- Added: Improved Invoice Builder (Adding Invoicing PRO)
- Added: Customer ID's exposed on customer record
- Added: Customisable Prefix and Status options for Customers/Contacts etc. (via Custom Fields tab of settings) - prep for a more simple UI post v1.4
- Added: Better initial Prefix & Status options
- Added: "Add invoice" (or quote or transaction) from customer record page
- Fixed: Bug in main core lang integration
- Fixed: Bug in wh lang lib
- Fixed: Bug where "Data Tools" wasn't showing on slimline menu
- Fixed: Bug where "Quotes" were showing up on slimline menu, even if disabled
- Fixed: Bug where "Invoices" were showing up on slimline menu, even if disabled
- Fixed: Bug where "Invoices" and "Quotes" were showing up on ZBS Dash, even if disabled
- Fixed: Bug where archived transaction dates were not saving down properly
- Fixed: Bug in internal automator workflow for new quotes, invoices, transactions that was causing duplicate logs
- Fixed: Bug in internal automator causing derails on some post edits
- Fixed: Bug in client portal where styling wasn't looking great on some public themes
- Fixed: Typo on settings page
- Improved: Asked all browsers to kindly NOT autofill customer record details (and same for quotes, invoices, transactions, forms, and logs)
- Improved: Moved Customer Metabox properly into translation functions (Quotes, Invoices, Transactions)
- Improved: Hid Quotes/Invoices on Customer record when these modules disabled
- Improved: Welcome Wizard improvements (ease of use)
- Improved: Email Notification templating (in prep for Invoicing Pro notification emails)
- Improved: CSV Importer PRO: Can now import & create company records from CSV
- Improved: CSV Importer PRO: Example files now included
- Improved: DAL for Contact/Company links (B2B)
- Improved: PayPal Sync (Settings page rewrite)
- NEW TRANSLATION: Spanish! You can now manage your customers etc. in Spanish (Thank you @HenryGR!)

## 1.2.6 - 2017-01-24

- Added: Support for Gravity Forms Integration
- Improved: Extensions manager now properly shows installed pro extensions and help docs
- Fixed: Slimline menu now displays forms

## 1.2.5 - 2017-01-19

- Added: Ability to enable/disable Quotes/Quote Builder
- Added: Ability to enable/disable Invoices/Invoice Builder
- Added: Ability to choose simple Quote Logger (instead of proposal writing via Quote Builder)
- Added: Quote Templates
- Added: Quote Template: ZBS Default Template: Web Design Example
- Added: Quote Builder Flow
- Added: Quote Template Writer: Insert tool for placeholders
- Added: Quote/Proposal Front-end
- Added: Email Quote/Proposal to client
- Added: Online accepting for Quotes/Proposals (sign with email)
- Added: Notification email for quote author when accepted
- Improved: Styles for Extensions Page
- Improved: Variable names in Quotes metabox file
- Improved: Building of Quote Templates
- Fixed: All ZBS custom post types are now secured from being shown in FE (Thanks for feedback)
- Fixed: Bug in quotation customer associations
- Fixed: Outdated config bloat
- Fixed: lettering issue on some servers (uppercase/lowercase include file names)
- Fixed: Bug in style enqueuing
- Fixed: Bug causing Welcome Wizard to not display

## 1.2.4 - 2016-12-29

- Fixed: Bug in Invoicing status
- Fixed: Front-end exposure of customer titles

## 1.2.3 - 2016-12-15

- Added: Default invoice logo in settings
- Added: Invoice Status drop down select UI
- Added: Overdue styling for invoice admin
- Added: Sweet Alert for displaying JS alert messages
- Added: CRON integration for clearing auto-drafts
- Added: Auto-clearance of ZBS CRM type auto-drafts
- Added: Auto-clearance check to system status page
- Added: Migration for ~v1.2.3 to v1.2.3 (zbsid proper rollout)
- Added: Migration logs to System Status Page
- Improved: CSS for invoices now they are 2 column
- Improved: "Make Invoice from Quote" now pre-fills send-to email
- Hardened: Invoice Numbers and Quote Numbers now explicit throughout
- Bugfix which doubled the invoice total if tax was turned off
- Bugfix which meant draft invoices were not shown under the 'Manage Invoices' page
- Fixed: Bug in invoices showing warning
- Fixed: Bug in export which now properly outputs invoice id's
- Fixed: Bug in export which now properly outputs quote id's

## 1.2.2 - 2016-12-06

- Small bugfix for invoice creation

## 1.2.1 - 2016-11-15

- Small bugfix rolling over from 1.2 large update

## 1.2.0 - 2016-11-15

- Added: New Menu Layout Options (1=Full, 2=Slimline, 3=CRM Only)
- Added: New CRM Dashboard
- Added: Country Code Support
- Added: Customer/Contact Search *BETA*
- Added: Filtered exports from the new Customer Search
- Added: Filter customers by Tag (in Customer Search)
- Added: Autologging of new transactions (optionally) against customer
- Added: Transaction Tagging
- Added: Links to import and 'add new' customer to the Customer Search
- Improved: Moved import and export menu items under data tools
- Improved: Fully refactored all Zero BS CRM Code
- Improved: Security of core code
- Improved: Added Transaction Integration Functions (JVZoo Support Imminent)
- Improved: Made Transaction a hard typed object
- Improved: Invoicing now has post-delete (and pre-cursors to custom actions)
- Improved: Invoice Building is now responsive
- Improved: Removed unnecessary menu bar items for Customers, Quotes, Invoices, Transactions, Forms and Mail Campaigns
- Fixed: Bug in transactions editor with dates
- Fixed: Bug in transactions editor with customer names
- Fixed: Bug in transactions menu
- Fixed: Invoicing custom fields removed
- Fixed: Bug in invoices which hid the partial payments
- Fixed: Bug in invoices which was causing invoices not to be marked as unpaid
- Fixed: Bug in invoices which was displaying editable custom fields in preview
- Fixed: Bug in invoices which was adding on tax when the tax option was unchecked
- Fixed: Bug in invoices which was deducting a discount when the discount option was unchecked
- Fixed: Front-end access of customers etc. now redirects to root (rather than a blank page, depending on mode)
- Extension update: Sales Dashboard now has improved checks against core

## 1.1.19 - 2016-10-25

- Added: Sortable field orders (re-arrange your customer/company etc. edit pages!)
- Added: BETA* Basic templating for addresses (via custom fields)
- Added: System Status page (pre-cursor to better support and future features)
- Added: Pre-cursors for global address formatting
- Added: First fix of Transaction list view
- Added: Company Logs
- Added: Company External Sources
- Added: Internal Automator Auto-logging (optional) for new companies
- Added: Migration routines between versions (first being Company names in 1.1.19)
- Added: Integration functions for creating Companies
- Added: Native support for Country in addresses (optional)
- Added: Countries support to custom field sorts
- Fixed: Bug in Mail Campaigns with Select by Tag
- Fixed: PDF Invoices Installer for those on hosts which have hard-disabled ZipArchive (Zlib)
- Fixed: Bug where new front-end form submissions were not defaulting to "Lead" status
- Fixed: Bug in transaction edit page
- Fixed: Bug in customer total values
- Fixed: Bug in WooSync where State was not copying over
- Fixed: Bug in Welcome Wizard which showed wrong extensions information
- Improved: Hid selective PDF Invoicing features for non-users, made it easy to install via 1 click button
- Improved: Added optimisation to stylesheet loading (performance tweak)
- Improved: Refactored SCSS and Stylesheets throughout (performance tweak)
- Improved: Centralised Note/Log Types
- Improved: Refactored javascript/asset references for performance, minified all js resources
- Extension Update: WooCommerce Sync now supports companies!

## 1.1.18 - 2016-10-11

- Added: PDF Invoicing!
- Added: Extensions Hub
- Added: Invoice - Transaction allocations (Part Payments!)
- Added: Typeahead customer search
- Added: Typeahead customer listings to quote editing
- Added: Transactions now editable via admin menu (manual add)
- Added: logging of form source, (e.g. "New Lead created from submitted form 'A' on page 'B'")
- Added: logging of forms post creation, (e.g."User filled out form 'A' on an external embedded form")
- Added: Custom "moved to trash" pages for customers, quotes, invoices and transactions
- Added: default customer status for imports, lead form completions etc. of "Lead"
- Added: "Form Filled" type note
- Added: View customer image in new tab function (& restyled)
- Added: Bloodhound.js - the start of integrated search
- Added: several more wrapper functions for getting customer data sets
- Added: JVZoo external customer type
- Added: Enable/Disable Powered by link on front end forms
- Added: Typeahead customer search to transactions
- Added: Precursors for internal automator to fire on transaction changes
- Improved: Forms can now be enabled/disabled (via Extensions Hub)
- Improved: Custom Fields can now be enabled/disabled (via Extensions Hub)
- Improved: PDF Invoicing is an optional extra (via Extensions Hub) - keeps ZBS lean for everyone else
- Improved: PDF invoices restyled first fix
- Improved: Notes are no longer used for storing customer lead form data, this now gets added as a log
- Improved: Notes created by ZBS CRM system are not editable
- Improved: Logs metabox is now responsive, (looks cleaner in right hand bar on customer edit)
- Improved: Internal Automator (prep for sophisticated workflow creation)
- Improved: Rearranged ZBS Menu to better highlight extensions
- Improved: Non-essential extensions, (like PDF invoicing), are now installed via 1-click extension hub
- Improved: PDF Invoicing cleans up after itself
- Improved: Removed Post Titles from Transactions
- Fixed: Logs now display proper timezone-based creation times, taking into account WordPress timezones
- Fixed: Worked through all WH Later Refinement points & fixed/delayed
- Fixed: Edit transactions fixed
- Fixed: PHP Version warning reinstated
- Fixed: bug where % and $ would not store (invoicing)
- Fixed: bug where business information would display on one line (invoicing)
- Fixed: styling bug in all transactions screen
- Fixed: bug where total customer value would include allocated transactions as well as invoice
- Fixed: bug with PDF Invoicing settings page
- Removed: Customer Image repetition (showed up twice on page)

## 1.1.17 - 2016-09-13

- Added: Customer Lead Forms
- Added: reCaptcha to Lead Forms
- Added: 3 x Form variants (simple, naked and content forms)
- Added: Embed Forms
- Added: Data tools: Bulk Delete (Delete customers from different sources, in bulk)
- Added: Export Tools: Export your customers, invoices, quotes, and transactions
- Updated: CSV Extension plugin (v1.1)

## 1.1.16 - 2016-08-30

- Added: Itemised Invoice Creator (Create + Send Invoices!)
- Added: First Fix Internal Automator
- Added: Automatic Logging of: New Customer
- Added: Automatic Logging of: New Company
- Added: Automatic Logging of: New Quote
- Added: Automatic Logging of: New Invoice
- Improved: Security: Added proper nonce's throughout
- Fixed: Bug in Invoice list which showed invoice numbers incorrectly
- Fixed: Bug in Customer Editor which showed invoice numbers incorrectly

## 1.1.15 - 2016-08-25

- Improved: Activity Logs: Corrected Label to show active count

## 1.1.14 - 2016-08-16

- Added: Welcome Wizard

## 1.1.13 - 2016-08-09

- Added: Logging/Notes: Delete a note (ajax)
- Improved: Logging styles

## 1.1.12 - 2016-08-02

- Added: Logging (Log calls, emails, quotes, invoices, purchases against customers)
- Added: Logging Icons
- Added: Logging of tweets & facebook posts
- Added: Custom Footer Text & option to enable/disable it from Zero BS CRM Settings
- Added: Review ZBS CRM to footer of ZBS pages
- Tidied up: Companies metabox code

## 1.1.10 - 2016-07-19

- Added: Custom Fields for Companies/Organisations
- Added: View Customers/Contacts by Company/Organisation
- Added: View Contacts from Company page (Contact Cards)
- Added: Optional "B2B" Mode (Allows grouping of customers as contacts, against a company)
- Added: Before you go
- Improved: Company updated msgs
- Optimised: Settings page
- Removed some legacy v1.0 includes code
- Fixed: Plural customers, contacts, companies, organisations
- Fixed bug: In settings initialisation
- Fixed bug: In require metabox include
- Fixed bug: Manage Quotes, Invoices would show "," where customer address empty
- Fixed bug: Icon dimensions

## 1.1.7 - 2016-07-12

- Optimised Second Address form for wide screens
- Added "Second Address" against customers (Optional)
- Added "Create Invoice from Quote" feature
- Wired in new quote/invoice options
- Added "Quote no# Offset" setting
- Added "Invoice no# Offset" setting
- Added "Allow Invoice No Override" setting
- Added Extensions Page to Plugin
- Added Data Tools page
- Improved WordPress .org Description

## 1.1.6 - 2016-07-08

- Improved WordPress .org Description
- Fixed a bug with customer entry

## 1.0.0 - 2016-06-17

- Initial Release
- Fixed all bugs from Alpha 0.9
- Tested across 4 common web hosts
- Tested with extensions: WooCommerce CRM Sync, PayPal CRM Sync, CSV Importer, ZBS CRM Mail Campaigns, and CRM Sales Dashboard

[6.6.1]: https://github.com/Automattic/jetpack-crm/compare/6.6.0...6.6.1
[6.6.0]: https://github.com/Automattic/jetpack-crm/compare/6.5.1...6.6.0
[6.5.1]: https://github.com/Automattic/jetpack-crm/compare/6.5.0...6.5.1
[6.5.0]: https://github.com/Automattic/jetpack-crm/compare/6.4.4...6.5.0
[6.4.4]: https://github.com/Automattic/jetpack-crm/compare/6.4.3...6.4.4
[6.4.3]: https://github.com/Automattic/jetpack-crm/compare/6.4.2...6.4.3
[6.4.2]: https://github.com/Automattic/jetpack-crm/compare/6.4.1...6.4.2
[6.4.1]: https://github.com/Automattic/jetpack-crm/compare/6.4.0...6.4.1
[6.4.0]: https://github.com/Automattic/jetpack-crm/compare/6.3.2...6.4.0
[6.3.2]: https://github.com/Automattic/jetpack-crm/compare/6.3.1...6.3.2
[6.3.1]: https://github.com/Automattic/jetpack-crm/compare/6.3.0...6.3.1
[6.3.0]: https://github.com/Automattic/jetpack-crm/compare/6.2.0...6.3.0
[6.2.0]: https://github.com/Automattic/jetpack-crm/compare/6.1.0...6.2.0
[6.1.0]: https://github.com/Automattic/jetpack-crm/compare/6.0.0...6.1.0
[6.0.0]: https://github.com/Automattic/jetpack-crm/compare/5.8.0...6.0.0
[5.8.0]: https://github.com/Automattic/jetpack-crm/compare/5.7.0...5.8.0
[5.7.0]: https://github.com/Automattic/jetpack-crm/compare/5.6.0...5.7.0
