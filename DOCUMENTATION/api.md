email: admin@example.com
password:  admin

OR

user.name: test@example.com
password:  test


API:
##.../api/news
---------------
VSTUP: 
---------------
VYSTUP: vypíše všechny novinky

---------------
---------------

##.../api/login
----------------
POST : VSTUP: 

    email : admin@example.com
    password : admin
----------------    
VYSTUP:

    email :
    token :          
    code  : 
    description :
    
####zkontroluje zda existuje uživatel, zda heslo souhlasí. Zda existuje token uživatele, pokud ne- vytvoří. Pokud ano, a je po expiraci - vytvoří nový, v opačném případě pouze prodlouží expiraci

---------------
---------------

##.../api/token
---------------
POST : VSTUP: 

    token : (string)
---------------    
VYSTUP:

    code  :
    description :     
####zkontroluje zda existuje token a zda je či není po expiraci, pokud je po expiraci doporučuji provést odhlášení z aplikace   

---------------
---------------

##.../api/evaluation
-------------------
POST : VSTUP: 

    token : (string)
    news_id : (int)
    evaluation : (true/false)
------------------    
VYSTUP:  

    code  :
    description :  
###zkontroluje zda existuje token, a expiraci, pokud vše vpořádku zapiše hodnocení k článku    
