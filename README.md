## Example CRM

## Recursos

Essa aplicação é uma API, que contém os seguintes recursos:

- Laravel 8
- MySQL

**Obs.** Aplicação desenvolvida e testada em plataformas Windows.

## Ambiente

- PHP 8.1.1
- Nginx latest (atualmente 1.18) / PHP-FPM
- MySQL 8.0.20
- Composer 2
- XDebug 3

### Pré-Requisitos

- Ter o docker habilitado localmente.

### Instalação

- Copiar o arquivo `./src/.env.example` que corresponde as variáveis de ambiente da aplicação e o salve
  como `./src/.env` .

- Executar o seguinte comando.

```bash
docker-compose up -d --build
```

- Entrar no container da aplicação(`app_php`), gere a key do projeto

```bash
php artisan key:generate
```

- Ainda no container citado acima, execute a migrations.

```bash
php artisan migrate
```

- Se quiser, existe uma seeder de Clientes, para usa-lá. (Executar no container)

```bash
php artisan db:seed
```

## Execução da aplicação

- Para executar os endpoints, é indicado seguir a documentação no link: [Documentação da API](https://documenter.getpostman.com/view/13762067/2s8Z72UBKr)
