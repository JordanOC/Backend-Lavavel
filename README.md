## Sistema de Gerenciamento de Usuários e Produtos em Laravel (PHP)

Este é um sistema básico desenvolvido em Laravel para gerenciamento de usuários e produtos. O sistema oferece funcionalidades de cadastro, edição e importação de produtos e importação de uma API externa, além da integração com filas de processamento de tarefas em segundo plano.

### Funcionalidades
- Cadastro e edição de usuários 
- Cadastro e edição de produtos
- Importação de produtos de uma API externa
- Sistema de filas para processamento de jobs assíncronos
- Suporte para três soluções de filas: Docker, NSSM e LocalStack
Obs.: Por ter iniciado o desenvolvimento em sistema Windows, horizon e suas dependecias nao tinham suporte
- Instalação

#### Clone o repositório
```
git clone https://github.com/your-repo/sistema-laravel.git
cd sistema-laravel
```
#### Instale as dependências
Certifique-se de ter o Composer instalado e execute:

```
composer install`
```

#### Crie o arquivo .env
Crie uma cópia do arquivo .env.example e configure o arquivo .env de acordo com seu ambiente.

```
cp .env.example .env
```

#### Gere a chave da aplicação
```
php artisan key:generate
```

#### Configure o banco de dados
No arquivo .env, altere e/ou configure as credenciais do seu banco de dados.

```
env
Copy code
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

###### Depois, execute as migrações:
```
php artisan migrate
```

#### Inicie o servidor de desenvolvimento
```
php artisan serve
```

Agora, você pode acessar o sistema no navegador em http://localhost:8000.

### Soluções de Fila para Processamento de Jobs
Este sistema usa o Laravel Queue para processar tarefas de longa duração (como a importação de produtos) de forma assíncrona. Abaixo estão três alternativas para implementar filas: Docker, NSSM (Windows) e LocalStack.

#### Docker
Usando Docker e Docker Compose
O Docker permite a execução de containers para rodar o Redis (para filas) e a aplicação Laravel simultaneamente.

Passo 1: Inicie os containers com Docker Compose.
```
docker-compose up -d
```
Isso iniciará os serviços necessários, incluindo o Redis e o Laravel.

Passo 2: Se necessário, comente o serviço do LocalStack no arquivo docker-compose.yml se você não quiser usá-lo.
```
# Optional: comment out LocalStack service
# localstack:
#     image: localstack/localstack
#     ports:
#         - "4566:4566"
#     environment:
#         - SERVICES=sqs,s3
#         - DEBUG=1
#     volumes:
#         - "./localstack-data:/tmp/localstack"
```

Passo 3: Execute o worker da fila dentro do container.
```
docker exec -it laravel-app php artisan queue:work
```

#### NSSM - Non-Sucking Service Manager (Windows)
Se você estiver no Windows e quiser rodar o worker de filas como um serviço, pode usar o NSSM para isso.

Passo 1: Instale o NSSM. Baixe a ferramenta no site oficial do NSSM.

Passo 2: Instale o worker do Laravel como um serviço usando o NSSM.

```
nssm install LaravelWorker "C:\caminho\para\php.exe" "C:\caminho\para\seu\projeto\artisan" queue:work --sleep=3 --tries=3
```

Passo 3: Inicie o serviço.
```
nssm start LaravelWorker
```
Agora, o worker estará rodando em segundo plano como um serviço no Windows.

#### LocalStack - Simulando Serviços AWS Localmente
LocalStack é uma plataforma que permite simular serviços da AWS localmente, como S3 e SQS. Essa solução é útil para desenvolvimento local sem necessidade de acessar os serviços reais da AWS.

Passo 1: Configure e rode o LocalStack com Docker.
```
docker-compose up -d
```

Passo 2: Crie um bucket S3 no LocalStack para armazenar os produtos.
```
aws --endpoint-url=http://localhost:4566 s3 mb s3://nome-do-bucket
```

Passo 3: Crie uma fila SQS no LocalStack.
```
aws --endpoint-url=http://localhost:4566 sqs create-queue --queue-name nome-da-fila
```
Passo 4: Atualize seu .env para apontar para o LocalStack:
```
env
QUEUE_CONNECTION=sqs
AWS_ACCESS_KEY_ID=localstack
AWS_SECRET_ACCESS_KEY=localstack
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=nome-do-bucket
AWS_SQS_PREFIX=http://localhost:4566/000000000000
```
Com essas configurações, seu sistema de filas estará rodando no LocalStack, permitindo o uso de SQS e S3 localmente.

### Testando o Sistema
- Acesse a aplicação via http://localhost:8000 e registre-se como usuário.
- Teste a importação de produtos de uma API externa clicando no botão "Importar Produtos - API Externa" (disponível apenas para usuários logados).
- Verifique as mensagens de sucesso para confirmar a importação bem-sucedida.
- Menu Adicionar Produto, cria um novo produto e categorias, e edita e exclui os mesmos
