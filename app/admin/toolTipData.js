var FiltersEnabled = 0; // if your not going to use transitions or filters in any of the tips set this to 0
var spacer="&nbsp; &nbsp; &nbsp; ";

// email notifications to admin
notifyAdminNewMembers0Tip=["", spacer+"No email notifications to admin."];
notifyAdminNewMembers1Tip=["", spacer+"Notify admin only when a new member is waiting for approval."];
notifyAdminNewMembers2Tip=["", spacer+"Notify admin for all new sign-ups."];

// visitorSignup
visitorSignup0Tip=["", spacer+"If this option is selected, visitors will not be able to join this group unless the admin manually moves them to this group from the admin area."];
visitorSignup1Tip=["", spacer+"If this option is selected, visitors can join this group but will not be able to sign in unless the admin approves them from the admin area."];
visitorSignup2Tip=["", spacer+"If this option is selected, visitors can join this group and will be able to sign in instantly with no need for admin approval."];

// invoice table
invoice_addTip=["",spacer+"This option allows all members of the group to add records to the 'Invoices' table. A member who adds a record to the table becomes the 'owner' of that record."];

invoice_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Invoices' table."];
invoice_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Invoices' table."];
invoice_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Invoices' table."];
invoice_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Invoices' table."];

invoice_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Invoices' table."];
invoice_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Invoices' table."];
invoice_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Invoices' table."];
invoice_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Invoices' table, regardless of their owner."];

invoice_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Invoices' table."];
invoice_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Invoices' table."];
invoice_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Invoices' table."];
invoice_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Invoices' table."];

// clients table
clients_addTip=["",spacer+"This option allows all members of the group to add records to the 'Clients' table. A member who adds a record to the table becomes the 'owner' of that record."];

clients_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Clients' table."];
clients_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Clients' table."];
clients_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Clients' table."];
clients_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Clients' table."];

clients_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Clients' table."];
clients_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Clients' table."];
clients_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Clients' table."];
clients_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Clients' table, regardless of their owner."];

clients_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Clients' table."];
clients_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Clients' table."];
clients_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Clients' table."];
clients_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Clients' table."];

// item_prices table
item_prices_addTip=["",spacer+"This option allows all members of the group to add records to the 'Prices History' table. A member who adds a record to the table becomes the 'owner' of that record."];

item_prices_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Prices History' table."];
item_prices_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Prices History' table."];
item_prices_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Prices History' table."];
item_prices_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Prices History' table."];

item_prices_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Prices History' table."];
item_prices_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Prices History' table."];
item_prices_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Prices History' table."];
item_prices_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Prices History' table, regardless of their owner."];

item_prices_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Prices History' table."];
item_prices_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Prices History' table."];
item_prices_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Prices History' table."];
item_prices_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Prices History' table."];

// invoice_items table
invoice_items_addTip=["",spacer+"This option allows all members of the group to add records to the 'Invoice items' table. A member who adds a record to the table becomes the 'owner' of that record."];

invoice_items_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Invoice items' table."];
invoice_items_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Invoice items' table."];
invoice_items_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Invoice items' table."];
invoice_items_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Invoice items' table."];

invoice_items_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Invoice items' table."];
invoice_items_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Invoice items' table."];
invoice_items_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Invoice items' table."];
invoice_items_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Invoice items' table, regardless of their owner."];

invoice_items_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Invoice items' table."];
invoice_items_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Invoice items' table."];
invoice_items_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Invoice items' table."];
invoice_items_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Invoice items' table."];

// items table
items_addTip=["",spacer+"This option allows all members of the group to add records to the 'Items' table. A member who adds a record to the table becomes the 'owner' of that record."];

items_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Items' table."];
items_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Items' table."];
items_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Items' table."];
items_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Items' table."];

items_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Items' table."];
items_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Items' table."];
items_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Items' table."];
items_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Items' table, regardless of their owner."];

items_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Items' table."];
items_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Items' table."];
items_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Items' table."];
items_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Items' table."];

// workorders table
workorders_addTip=["",spacer+"This option allows all members of the group to add records to the 'Work Orders' table. A member who adds a record to the table becomes the 'owner' of that record."];

workorders_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Work Orders' table."];
workorders_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Work Orders' table."];
workorders_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Work Orders' table."];
workorders_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Work Orders' table."];

workorders_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Work Orders' table."];
workorders_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Work Orders' table."];
workorders_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Work Orders' table."];
workorders_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Work Orders' table, regardless of their owner."];

workorders_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Work Orders' table."];
workorders_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Work Orders' table."];
workorders_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Work Orders' table."];
workorders_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Work Orders' table."];

// techs table
techs_addTip=["",spacer+"This option allows all members of the group to add records to the 'Techs' table. A member who adds a record to the table becomes the 'owner' of that record."];

techs_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Techs' table."];
techs_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Techs' table."];
techs_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Techs' table."];
techs_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Techs' table."];

techs_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Techs' table."];
techs_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Techs' table."];
techs_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Techs' table."];
techs_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Techs' table, regardless of their owner."];

techs_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Techs' table."];
techs_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Techs' table."];
techs_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Techs' table."];
techs_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Techs' table."];

// assets table
assets_addTip=["",spacer+"This option allows all members of the group to add records to the 'Assets' table. A member who adds a record to the table becomes the 'owner' of that record."];

assets_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Assets' table."];
assets_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Assets' table."];
assets_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Assets' table."];
assets_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Assets' table."];

assets_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Assets' table."];
assets_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Assets' table."];
assets_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Assets' table."];
assets_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Assets' table, regardless of their owner."];

assets_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Assets' table."];
assets_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Assets' table."];
assets_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Assets' table."];
assets_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Assets' table."];

// workordernotes table
workordernotes_addTip=["",spacer+"This option allows all members of the group to add records to the 'Work Order Notes' table. A member who adds a record to the table becomes the 'owner' of that record."];

workordernotes_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Work Order Notes' table."];
workordernotes_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Work Order Notes' table."];
workordernotes_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Work Order Notes' table."];
workordernotes_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Work Order Notes' table."];

workordernotes_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Work Order Notes' table."];
workordernotes_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Work Order Notes' table."];
workordernotes_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Work Order Notes' table."];
workordernotes_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Work Order Notes' table, regardless of their owner."];

workordernotes_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Work Order Notes' table."];
workordernotes_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Work Order Notes' table."];
workordernotes_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Work Order Notes' table."];
workordernotes_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Work Order Notes' table."];

// technotes table
technotes_addTip=["",spacer+"This option allows all members of the group to add records to the 'Technician Notes' table. A member who adds a record to the table becomes the 'owner' of that record."];

technotes_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Technician Notes' table."];
technotes_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Technician Notes' table."];
technotes_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Technician Notes' table."];
technotes_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Technician Notes' table."];

technotes_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Technician Notes' table."];
technotes_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Technician Notes' table."];
technotes_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Technician Notes' table."];
technotes_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Technician Notes' table, regardless of their owner."];

technotes_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Technician Notes' table."];
technotes_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Technician Notes' table."];
technotes_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Technician Notes' table."];
technotes_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Technician Notes' table."];

// tblwopubstatus table
tblwopubstatus_addTip=["",spacer+"This option allows all members of the group to add records to the 'Work Order Status' table. A member who adds a record to the table becomes the 'owner' of that record."];

tblwopubstatus_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Work Order Status' table."];
tblwopubstatus_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Work Order Status' table."];
tblwopubstatus_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Work Order Status' table."];
tblwopubstatus_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Work Order Status' table."];

tblwopubstatus_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Work Order Status' table."];
tblwopubstatus_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Work Order Status' table."];
tblwopubstatus_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Work Order Status' table."];
tblwopubstatus_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Work Order Status' table, regardless of their owner."];

tblwopubstatus_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Work Order Status' table."];
tblwopubstatus_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Work Order Status' table."];
tblwopubstatus_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Work Order Status' table."];
tblwopubstatus_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Work Order Status' table."];

// asset_notes table
asset_notes_addTip=["",spacer+"This option allows all members of the group to add records to the 'Asset notes' table. A member who adds a record to the table becomes the 'owner' of that record."];

asset_notes_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Asset notes' table."];
asset_notes_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Asset notes' table."];
asset_notes_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Asset notes' table."];
asset_notes_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Asset notes' table."];

asset_notes_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Asset notes' table."];
asset_notes_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Asset notes' table."];
asset_notes_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Asset notes' table."];
asset_notes_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Asset notes' table, regardless of their owner."];

asset_notes_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Asset notes' table."];
asset_notes_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Asset notes' table."];
asset_notes_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Asset notes' table."];
asset_notes_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Asset notes' table."];

// call_logs table
call_logs_addTip=["",spacer+"This option allows all members of the group to add records to the 'Call Logs' table. A member who adds a record to the table becomes the 'owner' of that record."];

call_logs_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Call Logs' table."];
call_logs_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Call Logs' table."];
call_logs_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Call Logs' table."];
call_logs_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Call Logs' table."];

call_logs_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Call Logs' table."];
call_logs_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Call Logs' table."];
call_logs_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Call Logs' table."];
call_logs_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Call Logs' table, regardless of their owner."];

call_logs_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Call Logs' table."];
call_logs_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Call Logs' table."];
call_logs_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Call Logs' table."];
call_logs_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Call Logs' table."];

// call_notes table
call_notes_addTip=["",spacer+"This option allows all members of the group to add records to the 'Call Notes' table. A member who adds a record to the table becomes the 'owner' of that record."];

call_notes_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Call Notes' table."];
call_notes_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Call Notes' table."];
call_notes_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Call Notes' table."];
call_notes_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Call Notes' table."];

call_notes_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Call Notes' table."];
call_notes_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Call Notes' table."];
call_notes_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Call Notes' table."];
call_notes_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Call Notes' table, regardless of their owner."];

call_notes_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Call Notes' table."];
call_notes_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Call Notes' table."];
call_notes_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Call Notes' table."];
call_notes_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Call Notes' table."];

// supportcase table
supportcase_addTip=["",spacer+"This option allows all members of the group to add records to the 'Support Cases' table. A member who adds a record to the table becomes the 'owner' of that record."];

supportcase_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Support Cases' table."];
supportcase_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Support Cases' table."];
supportcase_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Support Cases' table."];
supportcase_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Support Cases' table."];

supportcase_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Support Cases' table."];
supportcase_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Support Cases' table."];
supportcase_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Support Cases' table."];
supportcase_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Support Cases' table, regardless of their owner."];

supportcase_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Support Cases' table."];
supportcase_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Support Cases' table."];
supportcase_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Support Cases' table."];
supportcase_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Support Cases' table."];

// supportcase_notes table
supportcase_notes_addTip=["",spacer+"This option allows all members of the group to add records to the 'Activity Stream' table. A member who adds a record to the table becomes the 'owner' of that record."];

supportcase_notes_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Activity Stream' table."];
supportcase_notes_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Activity Stream' table."];
supportcase_notes_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Activity Stream' table."];
supportcase_notes_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Activity Stream' table."];

supportcase_notes_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Activity Stream' table."];
supportcase_notes_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Activity Stream' table."];
supportcase_notes_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Activity Stream' table."];
supportcase_notes_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Activity Stream' table, regardless of their owner."];

supportcase_notes_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Activity Stream' table."];
supportcase_notes_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Activity Stream' table."];
supportcase_notes_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Activity Stream' table."];
supportcase_notes_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Activity Stream' table."];

/*
	Style syntax:
	-------------
	[TitleColor,TextColor,TitleBgColor,TextBgColor,TitleBgImag,TextBgImag,TitleTextAlign,
	TextTextAlign,TitleFontFace,TextFontFace, TipPosition, StickyStyle, TitleFontSize,
	TextFontSize, Width, Height, BorderSize, PadTextArea, CoordinateX , CoordinateY,
	TransitionNumber, TransitionDuration, TransparencyLevel ,ShadowType, ShadowColor]

*/

toolTipStyle=["white","#00008B","#000099","#E6E6FA","","images/helpBg.gif","","","","\"Trebuchet MS\", sans-serif","","","","3",400,"",1,2,10,10,51,1,0,"",""];

applyCssFilter();
