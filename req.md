 * Plugin Name: Listing Engine Frontend
 * Plugin URI: https://arttechfuzion.com
 * Author: Art-Tech Fuzion


 sun ab plugin banana hai jisme mene ek template banaya hai screen folder mein list-view.html se uska replica karna hai and color mene pehle se set kar rkhe hai global-assets/css/global.css mein and font family ke liye inherit use karna hai taki wordpress mein jo font family ho wo use ho sake and make sure sare file seperated ho and sare path define karne ke liye and konse page par konsa assets load hoga uske liye proper assets-loader.php includes ke andar bana and also ek file url routing bhi bana if needed hoga future mein to samjha. 

 ab sun kaam ye hai ki ek shortcode bana jisko website mein jaha paste karu waha par wo template render ho jaye property list show ho and property par click karne par uski detail page open ho and wo detail page konsa hai wo pata chalega db se tu db mein request bhjega ki "wp_admin_management" mein name column mein "Listing Single View" name se koii entry hai ki nhi agar nhi hai to toaster aa jae page not found and agar hai to page_id se page ka id nikal kar wo page par redirect kar dega with url mein property id bhi pass kar dena but in a hidden way.


 ab sun list view page ki jaha sare list show honge shortcode se to ek to shortcode bana jisse render hoga jaha bhi wo shortcode mein dalu website mein to sare property and ab sun ek property ka kya kya detail hoga and kaise milega. 

 sabse pehle to tujhe `wp_ls_listings' mein se nikalna hoga kitna list hai and then ab ek list mein image, title, little detail, price hai to ab sun one by one kaise milega detail.

 IMAGE=>
 pehle to tu property id ke sath jaega  `wp_ls_img` table mein and isme wo property id se attavh entry dhundega property_id column mein and phir wo milne ke baad image column se data lega jo json mein hoga usko decode kar ke milega tujhe images (id, url, sort_order) aese aur bhi image hogi wo jason mein sabke pass ye detail hogi jisme sort_oder tere ko image ka order define karega and url se tu path pata laga sakta hai image ka and make sure jo sort_order mein hoga wese hi show karna hai image like 0 wala obvious cover image hoga sabse pehle phir 1 aese karke.

 TITLE=>
 ye to tujhko title banana hai like {type} in {location} aesa hoga title ab ye type milega tujhe `wp_ls_listings` ke type column se value and phir wo value le kar jaega `wp_ls_types` table mein and yaha id match karne ke baad `name` column se data mil jaega wo show karna hai and ab {location} iske liye same apne `wp_ls_listings` ke `location` column se data le lena and then `wp_ls_locations` table mein ja kar wo location id se match kar ke `name` column se data le lena wo show karna hai.


 LITTLE_TITTLE=>
yaha tujhe data show karna hai 2 like "1 bedroom, 1 bed" iske liye tujhe apne `wp_ls_listings` ke `bedroom` column se data le lena and then `bed` column se data le lena and then "1 bedroom" and "1 bed" ko " , " se join kar ke show karna hai.


PRICE =>

iske liye tujhe `wp_ls_listings` mein hi `price` mein se value mil jaega bas show aese karega {price}/night samjha. 

ab sun page ke top mein ek title hai "Over 1,000 homes in Noida" ye aesa show hoga like url agar clear hai sirf page ka name hai then "Premium Property" show hoga and agar url mein kuchh parameters passs ho rhe honge tab wo parameters mein ye find karega location kya hai and then "Over {count} homes in {location}" aesa show karega like "Over 1,000 homes in Noida" samjha. ye count to wo hai ki kitna list hai uss location mein like agar 10 list hai to "Over 10 homes in Noida" aesa show hoga samjha.

card mein ek heart icon bhi hai wo wishlist ke liye hai but abhi wo feature baad mein dalenge tab karenge to abhi sirf heart svg laga kar rkh de jo bs.

IMPORTANT POINTS:

make sure global.css se hi color use ho only and not any inline css in the code and also no rgba color and direct color in the code and font-family should be inhereted.

code should be crystal clear and all should have seperated files and folders and also make sure all the files are properly linked and all the paths are properly defined in assets-loader.php.

Make sure provide comments in the code show that we can identify easily ki konsa code kya kar rha hai.

 
ek toaster and confirmation ka bhi bana gloabl-assets mein css mein css and js mein js and whi use ho like toaster mein hamesa msg pass kiya jaega and call kiya jaega then ye show ho jaega jo 2 second baad automatically close ho jaega and confirmation mein ek msg and two button yes and no and yes par click karne par true jaega and phir usko jo function call karna ho kar sakta hai and no par false yani nhi karna hai. inka bhi ek template create karna hai global-assets mein hi template folder ke andar jo globally use honge mene bata diya hai.