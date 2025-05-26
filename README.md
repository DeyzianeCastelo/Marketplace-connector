# Marketplace Connector

Este sistema foi desenvolvido para realizar a integração entre um Marketplace e um Hub, simulando a importação de anúncios e o envio estruturado dos dados via API. A arquitetura foi pensada para ser escalável, desacoplada e de fácil manutenção, aplicando conceitos como Clean Architecture, filas assíncronas, controle de estados com o padrão State e separação clara de responsabilidades entre camadas.

## Tecnologias utilizadas

- PHP 8.3
- Laravel 12
- MySQL
- Docker + Laravel Sail
- Redis
- Queue/Jobs
- Events/Listeners
- Clean Architecture
- Design Pattern: State
- Repository Pattern
- Mockoon (mock de APIs REST)
- PSR-4 / PSR-12

## Como executar o projeto

### Pré-requisitos

- Docker
- Docker Compose
- PHP 8.x (caso execute localmente)
- Composer

### 1. Clonar o repositório

```bash
git clone https://github.com/DeyzianeCastelo/Marketplace-connector.git
cd marketplace-connector
```

### 2. Subir os containers com Laravel Sail

```bash
./vendor/bin/sail up -d
```

### 3. Rode as migrations

```bash
./vendor/bin/sail artisan migrate
```

### 4. Configure o Mockoon

Baixe o arquivo mocketplace.json e suba o mock via Docker:
```bash
docker run -d --mount type=bind,source="$(pwd)/mocketplace.json",target=/data,readonly -p 3000:3000 mockoon/cli:latest -d /data -p 3000
```
> As URLs da API mock estarão disponíveis em http://localhost:3000

### 5. Inicie a fila de jobs

```bash
./vendor/bin/sail artisan queue:work
```

### 6. Realize a requisição para importar anúncios com:

```bash
curl -X POST http://localhost/api/import-offers
```

## Arquitetura e padrões utilizados

- Clean Architecture: Separação clara entre camadas (Domínio, Casos de Uso, Infraestrutura, Interface)
- Repository Pattern: Comunicação com o banco de dados abstraída por interfaces
- State Pattern: Controle de estados de importação de cada anúncio (detalhes, imagens, preços)
- Jobs e Queues: Todas as etapas são processadas de forma assíncrona
- Redis: Usado como controle de estados e contador de partes completas
- Events/Listeners: Estrutura preparada para extensão com eventos
