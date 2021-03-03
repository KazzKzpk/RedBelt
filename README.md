# Gabriel Morgado

#### O que foi utilizado?
- KrupaBOX (framework backend)
- Twig (template HTML)
- Metronic (template)
- KrupaJS (framework frontend)
- MySQL (banco de dados)

#### Banco de dados
- Criar banco de dados com nome 'test'
- Criar credenciais (usuário: 'root' | senha: 'root')
- O migration é automático no primeiro acesso

#### Host
- Necessário Apache
- PHP 5.6-7.4 (recomendado 7.4)
- Mod Rewrite ativado
- Permissão de escrita na pasta /Application/ (chmod 777 em unix)

### Teste
- CRUD simples para adicionar/remover/atualizar/deletar usuário
- Usuário contém nome, email, telefone e CPF
- Email e CPF são chaves primárias
- Telefone e CPF são mascarados
- Tempo total de desenvolvimento: 70 minutos

# Acesso
- http://localhost

# Endpoints (API Restfull)
- Todos os endpoints podem receber qualquer tipo de dado.
- Ex: form-data, x-www-form-urlencoded ou raw (JSON, YAML, XML).
- O backend automaticamente entende o tipo de dado e converte. 

#### Listar todos usuários
- http://localhost/api/user
- Método: GET

#### Adicionar usuário
- http://localhost/api/user/add
- Método: GET
- Objeto: {name: 'Fulano', email: 'email@example.com', phone: '11982543321', cpf: '17223248211'}

#### Retornar usuário específico
- http://localhost/api/user/:id (ex: http://localhost/api/user/1)
- Método: GET

#### Atualizar usuário específico
- http://localhost/api/user/:id (ex: http://localhost/api/user/1)
- Método: POST
- Objeto: {name: 'Fulano', phone: '11982390991'}

#### Remover usuário específico
- http://localhost/api/user/:id (ex: http://localhost/api/user/1)
- Método: DELETE

# Detalhes

#### Banco de dados
- É possível alterar as credenciais do banco de dados em /Application/Config/Application.json
- Models do banco de dados estão em /Application/Server/Model/

#### Controladores
- Controladores HMVC do backend estão em /Application/Server/Controller/
- Controladores HMVC do frontend estão em /Application/Client/Controller/

#### Router
- Router do backend está em /Application/Server/Event/OnRoute.php
- Router do frontend está em /Application/Client/Event/OnRoute.php

#### HTML
- Views (Twig) está em /Application/Client/View/
- Template (Metronic) está em /Application/Client/Public/packages/metronic/

#### Assets
- SCSSs estão em /Application/Client/Public/assets/scss/ (compilado automaticamente)
- Imagens estão em /Application/Client/Public/img/