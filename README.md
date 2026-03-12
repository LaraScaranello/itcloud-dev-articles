# ITCloud 

Mini aplicação desenvolvida em **Laravel + Livewire** para gerenciamento de desenvolvedores e artigos técnicos.

O projeto permite cadastrar desenvolvedores, criar artigos e associar múltiplos desenvolvedores a cada artigo, com filtros em tempo real.

## 🚀 Tecnologias

- Laravel
- Livewire
- Tailwind CSS
- Pest (testes)

---

# 📦 Funcionalidades

### Autenticação
- Login
- Registro
- Reset de senha
- Proteção de rotas autenticadas

### Desenvolvedores
CRUD completo com:
- Nome
- Email único
- Senioridade (jr, pl, sr)
- Skills (tags)

### Artigos
CRUD completo com:
- Título
- Slug automático
- Conteúdo (HTML)
- Data de Publicação
- Upload opcional de imagem de capa
- Associação com múltiplos desenvolvedores

### Listagem
Interface responsiva:
- Desktop -> Grid de card
- Mobile -> Lista vertical

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

Testes automatizados utilizando **Pest**.

Cobertura inclui:

- Autenticação
- Proteção de rotas
- Criação de usuários

Rodar testes:

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
