# opencart-topup-extension
 topup extension for opencart v3.0.3.2

Install Database
	
	create 'topup' table
		- fields (topup_id,code[20](uniq),customer_id,amount,status,created_date,updated_date)

	create 'topup_history'
		- fields ("topup_history_id","topup_id", "amount", "mode"[0=>customer, 1=>admin, 2=>cashback], "transaction_reference", "created_date","created_by")
			- transaction_reference ==> transaction_id for mode [0 or 1] & order_id for mode=2
			- created_by ==> customer_id if mode [0 or 1] & "System" for mode[2]
			
Behavior,		
	Admin
		- Topup [list + add + edit + delete]
			- controller + model + twig
		- Topup history [list]
			- controller + model + twig
		- Customer topup + history
		- Place the extension under total folder. Check if the order total has listed with this module & install it.
	Customer
		- Account with topup [payment to be enabled only for credit-card]
		- Use topup during checkout
		
	
	
	
1. Create public repository "opencart-topup-extension" and share in bangalore group
2. updated Readme.md [ Add behavior ] & commit
3. Create below folder structure & commit "Admin folder structure"
	- admin
		- controller
			- extension
				- total
					- topup.php
		- language
		- model
		- view
	- catalog [To be done later]
4. Extension installation DB queries & commit
5. topup.php model 
	- getAllTopups() & commit
	- getTopupByUserId() & commit
	- getTopupById() & commit
	- addTopup() & commit
	- updateTopup() & commit
	- deleteTopup() & commit
	- getAllTopupHistories() & commit
	- getTopupHistoryByUserId() & commit
	- getTopupHistoryByTopuoId() & commit
	- addTopupHistory() & commit
6. topup.php controller
	- list() & commit
	- add() & commit
	- update() & commit
	- delete() & commit
	- listHistory() & commit
	- addHistory() & commit
7. topup_list.twig view
	- page header + table structure & commit
	- load all the topup & display as list & commit
	- delete topup & commit
	topup_form.twig view
		- show this page on add buton click with fields & commit
		- on submit, call backend & make sure topup gets saved & commit
		- show this page on edit button click with fields + values & commit
		- on submit, call backend & make sure topup gets updated & commit
	topup_history_list.twig view
	- page header + table structure & commit
	- load all the topup & display as list & commit
