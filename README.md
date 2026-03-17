# ITCloud 🚀

![Laravel](https://img.shields.io/badge/Laravel-Framework-red)
![Livewire](https://img.shields.io/badge/Livewire-Fullstack-blue)
![Tailwind](https://img.shields.io/badge/TailwindCSS-UI-38BDF8)
![PHP](https://img.shields.io/badge/PHP-8.5+-777BB4)
![Tests](https://img.shields.io/badge/Tests-Pest-green)

Mini aplicação desenvolvida com **Laravel + Livewire** para gerenciamento de **desenvolvedores** e **artigos técnicos**.

O sistema permite criar, organizar e relacionar conteúdos técnicos com múltiplos autores, incluindo filtros dinâmicos e interface responsiva.

---

## 🧠 Sobre o projeto

Este projeto foi desenvolvido com foco em:

* Arquitetura limpa e organizada
* Componentização com Livewire
* Experiência de usuário fluida (sem SPA)
* Código escalável e de fácil manutenção

---

## 🚀 Tecnologias

* Laravel
* Livewire
* Tailwind CSS
* Alpine.js
* Pest (testes)

---

## 🏗 Arquitetura

A aplicação segue uma abordagem baseada em **componentes e responsabilidade única**:

* 🔹 **Livewire Components** → UI dinâmica sem SPA
* 🔹 **Form Objects** → validação centralizada
* 🔹 **Soft Deletes** → exclusão segura
* 🔹 **Eloquent Relationships** → relacionamento entre entidades
* 🔹 **Factories & Seeders** → dados simulados para testes

---

## 📦 Funcionalidades

### 🔐 Autenticação

* Login
* Registro
* Reset de senha
* Proteção de rotas

---

### 👩‍💻 Desenvolvedores

* CRUD completo
* Senioridade (Jr, Pl, Sr)
* Skills (tags)

**Extras:**

* Filtros em tempo real
* Ordenação dinâmica
* Paginação
* Soft Delete (arquivar)
* Restore
* Force Delete

---

### 📝 Artigos

* CRUD completo
* Slug automático
* Conteúdo HTML
* Upload de imagem de capa
* Associação com múltiplos desenvolvedores

**Extras:**
* Filtros em tempo real
* Paginação
* Soft Delete (arquivar)
* Restore
* Force Delete

---

### 📱 Interface

* Totalmente responsiva
* Dark mode + Light mode 🌗

**Desktop:** Grid com cards
**Mobile:** Lista otimizada

---

## 🛠 Instalação

### Requisitos

* PHP >= 8.5
* Composer
* Node.js >= 18

---

```bash
git clone https://github.com/seu-usuario/itcloud-dev-articles.git
cd itcloud-dev-articles
composer install
npm install
cp .env.example .env
php artisan key:generate
```

---

### 🗄 Banco (SQLite)

```bash
touch database/database.sqlite
```

No `.env`:

```env
DB_CONNECTION=sqlite
```

```bash
php artisan migrate --seed
```

---

### 📁 Storage

```bash
php artisan storage:link
```

---

### ▶️ Rodando

```bash
php artisan serve
npm run dev
```

---

### 🚀 Produção

```bash
npm run build
```

---

## 🔐 Usuário de teste

Email: [demo@itcloud.com](mailto:demo@itcloud.com)

Senha: password

---

## 🧪 Testes

```bash
php artisan test
```

ou

```bash
php artisan test --parallel
```

Cobertura:

* Autenticação
* CRUD completo
* Soft Delete / Restore / Force Delete
* Filtros e listagens

---

## 📁 Estrutura

```
app/
 ├── Models
 ├── Livewire
database/
 ├── migrations
 ├── seeders
 ├── factories
tests/
```

---

## ⚡ Observações

* Projeto pronto para rodar localmente
* Banco SQLite incluso
* Dados populados automaticamente
* Foco em avaliação técnica e boas práticas

---

## 💡 Autor

Desenvolvido por Lara Scaranello
