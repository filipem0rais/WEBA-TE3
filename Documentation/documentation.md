# Documentation API

## Obtenir les Branches
Méthode : `GET`  
Action : `subject`

Pramètres :

- `fetchGrades` bool, par défaut `false`: inclut dans la réponse les Notes de chaque Branche dans un champ `grades`.

Réponse : Tableau de `Branche` en JSON, avec les champs : 

- `idSubject` id de la Branche
- `name` Nom de la Branche

Codes de retour :

- `204` si aucune branche
- `400` si mauvais format de la requête
- `200` si au moins une branche

URL d'exemple : `?action=subject&fetchGrades=true`

## Obtenir une branche
Méthode : `GET`  
Action : `subject`

Pramètres :

- `idSubject` int: id de la branche
- `fetchGrades` bool, par défaut `false`: inclut dans la réponse les Notes de la Branche dans un champ `grades`.

Réponse : `Branche` en JSON, avec les champs : 

- `idSubject` id de la Branche
- `name` Nom de la Branche

Codes de retour :

- `404` si la branche n'existe pas
- `400` si mauvais format de la requête
- `200` si une branche

URL d'exemple : `?action=subject&fetchGrades=true`

## Obtenir les notes d'une branche
Méthode : `GET`  
Action : `grade`

Pramètres :

- `bySubjectId` : int: id de la branche

Réponse : Tableau des `Notes` en JSON, avec les champs :

- `idGrade` id de la note
- `idSubject` id de la branche
- `description` description de la note
- `value` valeur de la note
- `date` date de la note

Codes de retour :

- `204` 
- `400` si mauvais format de la requête
- `200` ???

URL d'exemple : `?action=grade&bySubjectId=2`

## Obtenir une note
Méthode : `GET`  
Action : `grade`

Pramètres :

- `byGradeId` : int: id de la note

Réponse : `Note` avec tous les champs, ce n'est pas un tableau :

- `idGrade` id de la note
- `idSubject` id de la branche
- `description` description de la note
- `value` valeur de la note
- `date` date de la note

Codes de retour :

- `204` ???
- `400` si mauvais format de la requête
- `200` ???

URL d'exemple : `?action=grade&byGradeId=3`

## Ajouter une note
Méthode : `PUT`  
Action : `addGrade`

Pramètres :

- `idSubject` int: id de la branche où va être ajouter la note
- `value` int: valeur de la note entre 1 et 6 avec une décimale

Réponse : `idGrade` en JSON, retour de l'`id` de la note créée 

Codes de retour :

- `404` si la branche n'existe pas
- `400` si mauvais format de la requête
- `201` si la note a été ajoutée


URL d'exemple : `?action=addGrade&idSubject=10&value=4`

## Supprimer une note
Méthode : `PUT`  
Action : `addGrade`

Pramètres :

- `idGrade` int: id de la note a supprimé

Réponse : aucune réponse

Codes de retour :

- `404` si la note n'existe pas
- `400` si mauvais format de la requête
- `204` si la note a été supprimée


URL d'exemple : `?action=deleteGrade&idGrade=12`

## Moyenne d'une branche
Méthode : `GET`  
Action : `subjectAverage`

Pramètres :

- `idSubject` int: id de la branche où va être calculé la moyenne

Réponse : Moyenne en JSON

Codes de retour :

- `404` si la branche n'existe pas
- `400` si mauvais format de la requête
- `200` si le calcul de la moyenne a été effectué


URL d'exemple : `?action=subjectAverage&idSubject=2`

