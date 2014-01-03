la branch fixCarteACtionEtAchetable est la derniere. Elle n'est pas mergee dans master encore parce qu'elle a un bug majeur. 


20140103

bug1: a cause de l'utilisation de gestionInstance, les caseDeJeuAction pointent tous vers le meme objet lors
de la creation dans caseActionDataMapper ligne 79. Il faudrait que caseDeJeuAction cree un objet qui est la la 
case Chance ou CC, et utilise celui-ci, ou que ces cases aient la position dans leur clé. 


