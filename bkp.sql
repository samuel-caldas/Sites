set foreign_key_checks=0;


#
# Criação da Tabela : card
#

CREATE TABLE `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensagem` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

#
# Dados a serem incluídos na tabela
#

