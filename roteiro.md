# Roteiro Vídeo – Desafio Técnico

Tempo estimado: 6-8 minutos

# 1. Introdução

Apresentação:

"Olá, meu nome é Lara e vou apresentar a aplicação que desenvolvi para o desafio técnico
proposto pela empresa, utilizando Laravel, Livewire e Tailwind CSS. 
A aplicação permite cadastrar desenvolvedores, criar artigos e associar múltiplos desenvolvedores 
a cada artigo".

---
# 2. Mostrar aplicação rodando (1 min)

Abrir no navegador.

Explicar rapidamente:

- Sistema possui autenticação padrão do Laravel
- Login, registro e recuperação de senha

Fazer login com usuário demo

---
# 3. Estrutura do projeto (1 min)

Abrir o projeto no editor.

Mostrar estrutura principal:

app/
 - Models

database/
 - migrations
 - factories
 - seeders

tests/

Explicar:

"O projeto segue a estrutura padrão do Laravel, utilizando Eloquent ORM para lidar
com os modelos na pasta app/Models e migrations para controled o banco de dados."

---
# 4. Models (2 min)
### Model Developer (1 min):

Explicar campos:

- name
- email
- seniority

Mostrar relacionamento com skills:

belongsToMany(Skill::class)

Explicar:

"Um desenvolvedor pode ter várias skills."

Mostrar relacionamento com articles:

belongsToMany(Article::class)

Explicar:

"Também existe relação many-to-many entre artigos e desenvolvedores."

### Model Articles (1 min):

Abrir Article.php.

Mostrar relacionamento:

belongsToMany(Developer::class)

Explicar:

"Cada artigo pode ter múltiplos desenvolvedores associados."

Mostrar geração automática de slug:

Str::slug + uniqid

Explicar:

"O slug é gerado automaticamente ao criar o artigo."

---

# 6. Migrations (40s)

Abrir migrations.

Mostrar tabelas principais:

- developers
- skills
- articles

Mostrar tabelas pivot:

- developer_skill
- article_developer

Explicar:

"Essas tabelas pivot são responsáveis por representar as relações many-to-many."

---

# 7. Factories e Seeders (40s)

Abrir DatabaseSeeder.

Explicar:

"Foram criadas factories e seeders utilizando Faker para gerar dados de teste automaticamente."

Mostrar criação de:

- skills
- developers
- articles

E associação entre eles.

---

# 8. Testes (30s)

Mostrar pasta tests.

Rodar no terminal:

php artisan test

Explicar:

"Foram incluídos testes utilizando Pest para validar funcionalidades básicas como autenticação e proteção de rotas."

---

# 9. Encerramento (15s)

"Obrigado pela oportunidade. Qualquer dúvida fico à disposição."
