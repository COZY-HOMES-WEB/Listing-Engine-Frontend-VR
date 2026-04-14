listen ek template create kar with name `database.php` and isko create karna hai `backend/template/` folder mein.

ye jo template bana rha hai ye exact replica hona chahiye `screens/database.html` ka. isme ek card banana hai jisme refresh par current status fetch karega db se ki usme table created hai to `yes` nhi hai to `no` dikhaega table created mein and row mein koii missing hai to rows complete mein `no` show karega.

Create/Repair button click karne par ye includes/class-db-handler.php mein jaega and waha ek function hoga usko trigger karega wo function ye dekhega ki table hai ya nhi agar nhi hai to create karega and agar hai to check karega ki rows complete hai ya nhi agar nhi hai to add karega. Ab ye sab ke liye isko malum hona chahiye ki wo table ka name and rows kya hai to uske liye ye `includes/db-schema.php` mein pura table ka query likha hoga usko dekhega and karega uske according work.

wp_ls_reservation TABLE =>

iska name `wp_ls_reservation` hai and isme columns jo honge wo ye hai "user_id, property_id, reserve_date, total_guests, total_price, status, created_at, updated_at".

NOTE=> 
1. ye pura aesa bana ki kisi par koii mainly dependent na rhe faltu ka jitna ho sake independent ho taki in future koii new function add karne mein issue na create ho. and ha ye pura aesa bana ki kisi ko bhi easily samajh aa jae and isme koii faltu ka code na ho and comments proper ache formate wala daliyo ki konsa chij kis chij ke liye hai.

2. ab jo colors hai wo direct color code nhi hone chahiye wo sare global-assets/css/global.css se lega as a variable and font-family bhi samjha "strictly keh rha hu koii direct color code, direct rgba, inline css nhi hona chahiye code mein".

3. ab sun global-assets mein tujhe toaster and confirmation popup bhi mil jaega unko use kar sakta hai for notification and confirmation and make sure use karne se pehle dekh liyo wo work kaise karta hai.


