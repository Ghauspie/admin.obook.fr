# Dictionnaire de données

## URLAPOTHEOSE (`URLAPOTHEOSE`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de l'URLAPOTHEOSE|
|URL|VARCHAR(255)|NOT NULL|L'url de l'apothéose|
|apotheose_id|Integer|NULL|L'ID de l'apothéose en question'|

## APOTHEOSE (`APOTHEOSE`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de l'APOTHEOSE|
|promo|VARCHAR(100)|NOT NULL|Le nom de la promo|
|description|TEXT|NOT NULL|un recap de la promo|
|is_publish|Boolean|Not null|définie si c'est cette promo qu'on affiche ou non|


## Marque (`RESET_PASSWORD_REQEST`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|L'identifiant de la marque|
|user_id|int|NOT NULL|L'id de l'user'|
|ipuser|VARCHAR(80)|NOT NULL, DEFAULT 0|L'ordre d'affichage de la marque dans le footer (0=pas affichée dans le footer)|
|hashed_token| VARCHAR(100)| NOT NULL| LE token de reset|
|created_at|TIMESTAMP|DEFAULT CURRENT_TIMESTAMP|La date de création de la marque|
|requested_at|TIMESTAMP|DEFAULT CURRENT_TIMESTAMP|La date de la dernière mise à jour de la marque|
|expires_at|TIMESTAMP|DEFAULT CURRENT_TIMESTAMP +1|La date de la dernière mise à jour de la marque|

