SELECT * FROM TBL_USUARIOS;
SELECT * FROM TBL_VAGAS;

SELECT u.nome,v.titulo as titulo_vaga FROM TBL_USUARIOS u
inner join tbl_vagas v
on u.usuario_id = v.usuario_id