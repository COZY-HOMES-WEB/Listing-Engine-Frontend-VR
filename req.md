sun ab ek screens folder mein `selected-list-view.html` ko read kar and usme tujhe 2 view show honge ek grid view and ek carousel view to first ye kaam hai tera ki ek template create kar `selected-list-view.php` se jisme dono view design kar deifferent different and ye file ka css and js bhi alag bana.

Now shortcode design karne mein lag ja jisse ye view show hoga jaha paster karunga.
[selected_list_view] - isse show hoga frontend mein samjha. ab isme kuchh modification hai. 

[selected_list_view view="grid"] - isse grid view show hoga.
[selected_list_view view="carousel"] - isse carousel view show hoga.
(by deafult grid view hona chahiye so grid wale shortcode ki need nhi hai)

ab inme bhi kuchh changes hai like if admin wants to show specific amount of list like usko 10 show karne ho ya 5 to uske liye wo shortcode mein hi value dalega and phir uske according show hoga 

[selected_list_view view="grid" count="10"] - isse grid view show hoga 10 list ke sath.
[selected_list_view view="carousel" count="5"] - isse carousel view show hoga 5 list ke sath. (By default 10 value hogi means if user value nhi deta hai to 10 hi show hoga by default)

ab maan le user ko specific location ke list show karne ho to uske liye bhi ek hona chahiye 

[selected_list_view view="grid" count="10" location="new york"] - isse grid view show hoga 10 list ke sath new york ke. 

tab ye db mein search karega `wp_ls_location` table mein and jab mil jaega tab uska id le kar jaega `wp_ls_listings` table mein and iske `location` column mein search karega or match karega same id and jo match hoga wo list utha kar show karega.

ab maan le usko show karna hai koii specific type ka list like usko show karna hai ki "home", "apartment" etc to uske liye bhi ek hona chahiye ek shortcode jisme wo type pass karega like 

[selected_list_view view="grid" count="10" location="new york" type="home"] - isse grid view show hoga 10 list ke sath new york ke and type home ka. 

abhi isme hoga ye ki ye db mein `wp_ls_types`, `wp_ls_location` ye dono table mein shortcode mein jo type and location ka value hai unko match karega name naam ke column mein and then `wp_ls_listings` table mein `type` and `location` column mein match karega or jo match hoga wo list utha kar show karega. 

isme ek varient ye bhi hoga like if user without location sirf type se karega like [selected_list_view view="grid" count="10" type="home"] kuchh aesa tab ye sirf `wp_ls_types` table mein type ko match karega or jo match hoga wo list utha kar show karega. 
(listen upper agar user koii parameter nhi deta hai type and location ka so by default latest entry show hongi)


ab sun sare listing ke last mein ek see all ka card hoga tujhe ye usme bhi milega jo ui refrence ke liye follow karega usme. to wo card hold karega kuchh parameter according to the shortcode.

1. agar shortcode mein koii parameter nhi hai then wo normal `wp_admin_management` table mein jaega and ek entry dhundega `name` columns mein `Listing Archive` and phir uska value `page_id` column se mil jaega phir isko wo see all card hold karke rkhega and jaise hi user click karega to wo waha redirect kar dega. 

2. Agar shotcode mein koii parameter hai like "type" "location" then uska value bhi hold karega see all card mein and jaise hi user click karega to wo uss page par redirect karega and uss page par bhi same filter apply hoga jo shortcode mein tha. (www.website.com/page_id?location=new+york&type=home) aesa kuchh samjha.


NOTE: mene upper jitna bhi sab likha hai wo implement hona chahiye ek structure way mein with proper comments and proper coding style. Also make sure sare files seperated ho and dependent na ho kisi par taki in future changes karna easy rhe.



