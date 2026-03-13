# ITCloud 

Mini aplicação desenvolvida em **Laravel + Livewire** para gerenciamento de desenvolvedores e artigos técnicos.

O projeto permite cadastrar desenvolvedores, criar artigos e associar múltiplos desenvolvedores a cada artigo, com filtros em tempo real.

## 🚀 Tecnologias

- Laravel
- Livewire
- Tailwind CSS
- Pest (testes)
## 🏗 Arquitetura

A aplicação foi construída utilizando **Laravel + Livewire**, seguindo uma abordagem baseada em componentes.

Principais conceitos utilizados:

- **Livewire Components** para interação dinâmica sem necessidade de SPA.
- **Form Objects** para centralizar validações e manipulação de dados.
- **Soft Deletes** para gerenciamento seguro de exclusão de registros.
- **Eloquent Relationships** para associação entre Desenvolvedores e Artigos.
- **Factories e Seeders** para geração de dados de teste.

A interface foi construída com **Tailwind CSS**, garantindo responsividade e consistência visual.

---

# 📦 Funcionalidades

## Autenticação
- Login
- Registro
- Reset de senha
- Proteção de rotas autenticadas

## Desenvolvedores
CRUD completo com:

- Nome
- Email único
- Senioridade (Jr, Pl, Sr)
- Skills (tags)

Funcionalidades adicionais:

- Filtros em tempo real por nome, senioridade e skills
- Ordenação por nome, email e senioridade
- Paginação
- Arquivamento de desenvolvedores (Soft Delete)
- Restauração de desenvolvedores arquivados
- Exclusão permanente (Force Delete)

## Artigos
CRUD completo com:

- Título
- Slug automático
- Conteúdo (HTML)
- Data de publicação
- Upload opcional de imagem de capa
- Associação com múltiplos desenvolvedores

## Interface

Interface totalmente responsiva:

- **Desktop:** visualização em grid com cards
- **Mobile:** visualização em lista

Badges exibem:

- Quantidade de artigos por desenvolvedor
- Quantidade de desenvolvedores por artigo

---

# 🛠 Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/itcloud-dev-articles.git
```

2. Entrar no projeto:
```bash
cd itcloud-dev-articles
```

3. Instalar dependências:
```bash
composer install
npm install
```

4. Criar arquivo .env:
```bash
cp .env.example .env
```

5. Gerar chave de aplicação:
```bash
php artisan key:generate
```

6. Banco de dados: 

O projeto utiliza **SQLite** para facilitar a execução. 

O arquivo do banco já está incluído no projeto: 

database/database.sqlite 

Execute as migrations e seeders:
```bash
php artisan migrate --seed
```

7. Rodar aplicação:
```bash
php artisan serve
```

8. Compilar assets:
```bash
npm run dev
```

---

# 🔐 Usuário de demonstração

Email: demo@itcloud.com

Senha: password

---

# 🧪 Testes

O projeto possui testes automatizados utilizando **Pest**.

Cobertura inclui:

- Autenticação
- Proteção de rotas
- CRUD de desenvolvedores
- Arquivamento e restauração (Soft Delete)
- Exclusão permanente (Force Delete)
- Filtros e listagem de desenvolvedores

Para rodar os testes:

```bash
php artisan test
```

---

# 📁 Estrutura do Projeto

Principais diretórios:
- app/Models
- app/Livewire
- database/migrations
- database/seeders
- database/factories
- tests
