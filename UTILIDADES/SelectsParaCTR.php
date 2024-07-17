SELECT ctr_ficpadreshijos.id, ascen_descen,  A1.id, A1.fichero, A2.id, A2.fichero 
FROM ctr_ficpadreshijos, ctr_ficheros AS A1, ctr_ficheros AS A2
WHERE  id_procedimiento = A1.id
  AND  id_fichero =  A2.id
ORDER BY  A1.fichero,  ascen_descen, A2.fichero



 SELECT ctr_ficpadreshijos.id, ctr_ficpadreshijos.id_procedimiento,ctr_ficpadreshijos.id_fichero,
        ascen_descen, A1.fichero, A2.fichero 
   FROM ctr_ficpadreshijos, ctr_ficheros AS A1, ctr_ficheros AS A2
   WHERE  id_procedimiento = A1.id
     AND  id_fichero =  A2.id
ORDER BY  A1.fichero,  ascen_descen, A2.fichero
      
**********ascendientes *******************

SELECT ctr_ficpadreshijos.id, ctr_ficpadreshijos.id_procedimiento,ctr_ficpadreshijos.id_fichero,
        ascen_descen, A1.fichero, A2.fichero 
   FROM ctr_ficpadreshijos, ctr_ficheros AS A1, ctr_ficheros AS A2
   WHERE  id_procedimiento = A1.id
     AND  id_fichero =  A2.id
     AND  ascen_descen = 'A'
     AND  ctr_ficpadreshijos.id_procedimiento = 128
     and  ctr_ficpadreshijos.id_fichero not in ( 132, 14)
ORDER BY  A1.fichero,  ascen_descen, A2.fichero

















 
 SELECT *
  FROM ctr_ficheros t1
 WHERE NOT EXISTS (SELECT NULL
                     FROM ctr_ficpadreshijos t2
                    WHERE t2.id_procedimiento = t1.id)
                    
 SELECT *
  FROM ctr_ficheros t1
 WHERE NOT EXISTS (SELECT NULL
                     FROM ctr_ficpadreshijos t2
                    WHERE t2.id_procedimiento = t1.id
                    and   t2.ascen_descen='A')                   
                    
                    
                    
                    
select count(id_procedimiento), id_procedimiento, id_fichero
from ctr_ficpadreshijos
group by id_procedimiento,id_fichero




UPDATE `ctr_ficheros` SET `orden` = '2' WHERE carpeta  = 'Foros'; 

