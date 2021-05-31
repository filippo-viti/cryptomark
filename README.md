# CryptoMark
Wiki che si pone l'obiettivo di catalogare gli algoritmi di crittografia ed hash.

## Requisiti
- PHP >=8
- [Database MySQL](https://www.mysql.com/it/downloads/)
- [Composer](https://getcomposer.org/download)
- [Symfony CLI](https://symfony.com/download)

## Installazione
```bash
git clone https://github.com/filippo-viti/cryptomark
composer install
```

## Creazione del database
Per prima cosa, dovete creare l'utente su mysql, quindi,
utilizzando un client MySql o da linea di comando:
```sql
CREATE USER cryptomark@localhost IDENTIFIED BY 'cryptomark';
GRANT ALL PRIVILEGES ON cryptomark.* TO cryptomark@localhost WITH GRANT OPTION;
```

Eseguire i seguenti comandi per creare il database, lo schema e caricare i dati:
```bash
symfony console doctrine:database:create
symfony console doctrine:schema:create
symfony console doctrine:fixtures:load
```
In alternativa, in caso di problemi con questi comandi, è possibile importare il DB utilizzando il file ```dump-cryptomark.sql```

## Avvio del server
Per avviare il webserver:
```bash
symfony serve
```

## Accesso al sito
Per accedere al sito utilizzare l'url http://localhost:8000  
Nel database è presente un utente amministratore di default con le credenziali ```admin:admin```