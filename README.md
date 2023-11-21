```markdown
# Guia de Instalação - PI Buffet 2023

Siga estes passos simples para instalar o PI Buffet 2023 e ter seu serviço em execução em poucos minutos!

## Passo a Passo

### 1. Clone o Repositório

```bash
git clone https://github.com/MrAtoidi/PI-Buffet-2023.git
cd PI-Buffet-2023
```

### 2. Instale o Docker Desktop

Instale o [Docker Desktop](https://www.docker.com/products/docker-desktop).

### 3. Baixe o PHP

Baixe o PHP em [php.net](https://www.php.net/downloads).

### 4. Baixe o Composer

Baixe o Composer em [getcomposer.org](https://getcomposer.org/download/).

### 5. Atualize as Dependências

Vá até o diretório do código e execute:

```bash
composer update
```

**Possível erro:** Se ocorrer um erro, vá ao arquivo `PHP.ini` e descomente a linha "filename".

### 6. Instale as Dependências

Execute o comando:

```bash
composer install
```

### 7. Instale o Laravel Sail

Execute o comando:

```bash
composer require laravel/sail --dev
```

### 8. Inicie o Docker Compose

```bash
docker compose up
```

### 9. Configure o Laravel Sail

```bash
php artisan sail:install
```

Escolha o serviço MySQL quando solicitado.

### 10. Inicialize o Programa

Para iniciar a aplicação, execute:

```bash
./vendor/bin/sail up
```

## Acesso à Aplicação

A aplicação estará disponível em [http://localhost/](http://localhost/).

O PHPMyAdmin estará disponível em [http://localhost:8001/](http://localhost:8001/).

(Trello)[https://trello.com/invite/b/OAcMZvzk/ATTI1cf6ac2feeb973e2c85ab37319f4110d5A09505C/pi-buffet}
(Figma)[https://www.figma.com/file/dVFTcKMJE4LiR2nxzAauUp/PI-Buffet-2023?type=design&node-id=0%3A1&mode=design&t=YgSjRPgZMzkTNKjH-1]

Scrum:
    Listas priorizadas de funcionalidades ou tarefas no Product Backlog, mantidas em uma plataforma online, como Trello, ou similare
Nossas conversas foram feitas majoritariamente com dois aplicativos um de conversa e o outro de chamadas sendo eles Discord e o WhatsApp.
