sun ab ek template bana search baar ka and jaisa banana hai wo tujhe screens folder mein search.html se mil jaega usme 2 hai look ek 765px se bade ke liye and usse chote ke liye to wesa hi ekdam same ui banana hai tujhe.

ab sun jaise desktop mein search destination mein enter kar sakta hai kaha jana hai and wo input ke acording niche popup mein suggestions bhi show honge and make sure ye `wp_ls_location` table mein input wala search karega and isme nhi mila to also `wp_ls_listings` table ke `address` column mein search karega same name samjha and niche suggestion show karega and agar na mile exact to similar character, words wale karega samjha. 


date mein claender aaega and phir usme 2 date pick karega ek check-in and check-out hoga and phir guests wale mein guests select karega.

phir jaise hi search par click hoga tab ye destination wale ko `location={value}` date ko `checkin={value}&checkout={value}` and guests ko `guests={value}` and phir ye `wp_admin_management` table mein `Listing Archive` entry search karega name column mein and phir uska value `page_id` se lega and then uspr redirect kar dega with parameter in url `location={value}` date ko `checkin={value}&checkout={value}` and guests ko `guests={value}` samjha. 


now make sure all color and font-family global-assets/css/global.css se lega as a variable and sab file seperated hona chahiye and dependent nhi hona chahiye taki future mein koii changes ho to dusre affect na ho