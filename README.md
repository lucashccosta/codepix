# Codepix - Banco Simplificado

O Codepix é uma API Rest que simula transferências pix para as carteiras virtuais de
lojistas e clientes comuns. A aplicação foi separada em 4 serviços (`api-baas`, 
`api-identity`, `api-core`, `api-mail`) que rodam em containers docker.

# Arquitetura

![](./.github/assets/codepix-bank-simulator-arch.png)

# Filas
Para a gestão de filas, o Codepix utiliza o [RabbitMQ](https://www.rabbitmq.com/). O RabbitMQ é um 
software open source de mensageria que fornece uma forma de comunicação assíncrona de dados entre 
processos, aplicações ou servidores. 

![](./.github/assets/codepix-queues.png)

# Banco de dados
O banco de dados utilizado foi o [PostgreSQL](https://www.postgresql.org/). PostgreSQL é um sistema 
gerenciador de banco de dados objeto relacional, desenvolvido como projeto de código aberto.

![](./.github/assets/codepix-db.png)

# Rodando a aplicação
Antes de rodar a aplicação é necessário criar uma conta no [Mailtrap](https://mailtrap.io/) e 
configurar o arquivo (chaves MAIL*) `.docker/api-mail.env` com as chaves de configuração.

Após configurado, basta executar o script `bootstrap.sh` para subir automagicamente (`docker-compose`) 
toda a infraestrutura de serviços, criar a estrutura de de banco de dados (`migration strategy`) e 
criar usuários, carteiras e chaves pix (`seed strategy`).
```sh
$ ./bootstrap.sh
```
# Rest API
## Métodos
Requisições para a API devem seguir os padrões:
| Método | Descrição |
|---|---|
| `POST` | Utilizado para criar um novo registro. |

## Respostas

| Código | Descrição |
|---|---|
| `200` | Requisição executada com sucesso (success).|
| `201` | Recurso criado com sucesso (success).|
| `400` | Erros de validação ou os campos informados não existem no sistema.|
| `401` | Não autenticado.|
| `403` | Não autorizado.|
| `404` | Registro pesquisado não encontrado.|
| `422` | Erros de validação.|

## Autenticação
Nossa API utiliza [Json Web Tokens](https://jwt.io/) como forma de autenticação/autorização.
A criação dos tokens de acesso é de responsabilidade do serviço `api-identity`.

### Solicitar token de acesso
+ Endpoint: [POST] http://localhost:3020/sessions
+ Request (application/json)
    + Body
        ```json
            {
                "doc": "21540411419",
                "password": "123456" //senha padrão,
            }
        ```
+ Response (application/json)
    + Body
        ```json
            {
                "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjRjYWYxZjBhLWI4YTUtNDRmMy1hYTU3LTM2YjMxZWQxMmZhMiIsImRvYyI6IjIxNTQwNDExNDE5IiwiaWF0IjoxNjI1NzgzNTc5LCJleHAiOjE2MjU3ODcxNzl9.9-ziGBZRZJGKOdW6Y-E_ldRCQIThUZUvQRuiGfDqkds"
            }
        ```

## Bank as service
A simulação de transferências para as carteiras virtuais de lojistas e clientes é de responsabilidade 
do serviço `api-baas`. Conforme pode ser visto no diagrama arquitetural, esse serviço se comunica
com toda a infraestrutura de banco de dados e filas.

### Simular transferência
+ Endpoint: [POST] http://localhost:3030/api/transactions
+ Request (application/json)
    + Headers
        ```sh
            Authotization: Bearer [token]
            X-WALLET: cc7d7281-d278-43bb-9aac-210a08893bad [id da carteira de origem]
        ```
    + Body
        ```json
            {
                "key_code": "mayer.mable@example.com",
                "key_type": "email",
                "total": 5000 //em centavos (equivale a R$50,00)
            }
        ```
+ Response (application/json)
    + Body
        ```json
            {
                "success": true,
                "message": "Created.",
                "data": {
                    "id": "0b8f9464-dbca-425d-a01f-94307d3bdd9b",
                    "wallet_from": "cc7d7281-d278-43bb-9aac-210a08893bad",
                    "wallet_to": "373232d6-8b49-44bc-8424-afce7e47316c",
                    "total": 5000,
                    "gateway_code": null,
                    "status": "processing", //o status irá modificar após ser processado pelos outros serviços (filas)
                }
            }
        ```

### Observações
+ Antes de invocar os endpoints, verifique os usuários, carteiras e chaves que foram criados na base de dados 
e informe os respectivos valores nos parâmetros das requisições.
+ As seguintes portas precisam estar disponíveis para rodar corretamente os serviços:
    + PostgresDB: 5432
    + RabbitMQ: 5672 e 15672
    + Api-identity: 3020
    + Api-baas: 3030
    + Api-core: 3040
    + Api-mail: 3050
+ O arquivo `codePix.postman.json` é o json dos endpoints exportados da ferramenta API Client 
[Postman](https://www.postman.com/). Se preferir, acesse este link da 
[documentação da API](https://documenter.getpostman.com/view/51603/Tzm6jvco).

## Autor
Lucas Costa – [Linkedin](https://www.linkedin.com/in/lucashcruzcosta/)