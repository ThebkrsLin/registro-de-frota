# 🚚 Sistema de Registro de Frota

Sistema web desenvolvido em **PHP**, utilizando **Programação Orientada a Objetos (POO)** e **PDO**, com o objetivo de realizar o cadastro e gerenciamento de **motoristas, veículos e suas associações**.

O projeto também possui controle de status dos registros e histórico das associações entre motoristas e veículos.

---

## 📋 Sobre o projeto

O **Sistema de Gestão de Frota** permite administrar informações de uma frota de veículos e dos motoristas responsáveis por eles.

A aplicação foi desenvolvida utilizando uma estrutura baseada em:

* Entities
* Services
* Repositories
* Banco de dados MySQL
* PDO para comunicação com o banco
* Programação Orientada a Objetos

O sistema permite cadastrar, consultar, atualizar e inativar registros, controlar a associação entre motoristas e veículos, além de visualizar da associação.

---

## ⚙️ Funcionalidades

### 👨‍✈️ Motoristas

* Cadastro de motoristas
* Validação de nome
* Validação de CPF
* Verificação de CPF duplicado
* Listagem de motoristas
* Atualização do nome
* Inativação de motoristas
* Ativação de motoristas
* Controle de data de criação e atualização

### 🚗 Veículos

* Cadastro de veículos
* Validação dos dados
* Verificação de placa duplicada
* Listagem de veículos
* Atualização da placa
* Atualização do modelo
* Atualização da marca
* Atualização do ano
* Inativação de veículos
* Ativação de veículos
* Controle de data de criação e atualização

### 🔗 Associação entre motorista e veículo

* Associar motorista a veículo
* Impedir associação com motorista inativo
* Impedir associação com veículo inativo
* Impedir que um motorista seja associado a mais de um veículo simultaneamente
* Desassociar motorista de veículo
* Registrar data de início da associação
* Registrar data de encerramento da associação

### 📜 Histórico

O sistema mantém o histórico das associações entre motoristas e veículos, permitindo consultar os registros anteriores de utilização.

---

## 🏗️ Estrutura do projeto

```text
registro-de-frota/
|
├── database/
|   ├── schema.sql
│
├── public/
│   ├── index.php
│   ├── historico.php
│   ├── style.css
│   └── Connection.php
│
├── src/
│   ├── entities/
│   │   ├── Motorista.php
│   │   └── Veiculo.php
│   │
│   ├── repository/
│   │   ├── MotoristaRepository.php
│   │   └── VeiculoRepository.php
│   │
│   └── services/
│       ├── MotoristaService.php
│       └── VeiculoService.php
│
└── README.md
```

> A estrutura acima pode ser ajustada caso a organização das pastas do projeto seja diferente.

---

## 🧩 Arquitetura

O projeto utiliza uma separação de responsabilidades entre as principais camadas da aplicação.

### schema.sql

O projeto já possui um script sql para a criação do banco apenas implemente usando programas como o Mysql Workbench ou phpmyadmin para criar o banco e as tabelas.

### Entities

As entidades representam os objetos principais do sistema:

* `Motorista`
* `Veiculo`

Elas armazenam os dados e possuem regras relacionadas ao próprio objeto, como validações, atualização de informações e controle de status.

### Repository

Os repositories são responsáveis pela comunicação com o banco de dados.

Exemplos:

```text
MotoristaRepository
VeiculoRepository
```

Eles realizam operações como:

* INSERT
* SELECT
* UPDATE
* consultas por ID
* consultas por CPF
* consultas por placa
* criação e encerramento de associações

### Service

Os services concentram as regras de negócio da aplicação.

Exemplos:

```text
MotoristaService
VeiculoService
```

Eles fazem a comunicação entre as entidades e os repositories, verificando regras antes de realizar determinadas operações.

---

## 🗄️ Banco de dados

O projeto utiliza **MySQL**.

O banco de dados utilizado é:

```text
logistica
```

### Tabelas

#### `motoristas`

Armazena os dados dos motoristas.

Principais campos:

```text
id
nome
cpf
ativo
created_at
updated_at
```

#### `veiculos`

Armazena os dados dos veículos.

Principais campos:

```text
id
placa
modelo
marca
ano
ativo
created_at
updated_at
```

#### `veiculo_motorista`

Responsável por registrar as associações entre veículos e motoristas.

Principais campos:

```text
id
veiculo_id
motorista_id
data_inicio
data_fim
```

A tabela possui relacionamentos com:

```text
veiculos
motoristas
```

---

## 🔐 Regras de negócio

O sistema possui algumas regras para manter a consistência dos dados.

### Motoristas

* O nome não pode ser vazio.
* O CPF deve possuir formato válido.
* Não é permitido cadastrar dois motoristas com o mesmo CPF.
* Motoristas inativos não podem ser associados a veículos.

### Veículos

* Placa, modelo e marca não podem ser vazios.
* A placa deve ser única.
* O ano deve estar entre **2010 e o ano atual**.
* Veículos inativos não podem ser associados a motoristas.

### Associação

* Um motorista não pode estar associado a dois veículos simultaneamente.
* Apenas motoristas ativos podem ser associados.
* Apenas veículos ativos podem ser associados.
* O encerramento da associação é registrado através da `data_fim`.
* Associações anteriores permanecem armazenadas para consulta do histórico.

---

## 🛠️ Tecnologias utilizadas

* **PHP**
* **Programação Orientada a Objetos (POO)**
* **PDO**
* **MySQL**
* **HTML5**
* **CSS3**

---

## 💻 Requisitos

Para executar o projeto localmente, é necessário ter:

* PHP
* MySQL
* Servidor Apache
* XAMPP ou ambiente equivalente

---

## 🚀 Como executar o projeto

### 1. Clone ou copie o projeto

Coloque o projeto dentro da pasta do servidor web.

No XAMPP, por exemplo:

```text
C:\xampp\htdocs\
```

---

### 2. Crie o banco de dados

Execute o script SQL fornecido no projeto.

O script cria o banco:

```sql
logistica
```

e as tabelas:

```text
motoristas
veiculos
veiculo_motorista
```

---

### 3. Configure a conexão

Verifique as informações utilizadas no arquivo:

```text
Connection.php
```

Exemplo de configuração utilizada no projeto:

```text
Host: localhost
Banco: logistica
Usuário: root
Senha: 
```

---

### 4. Inicie o XAMPP

Inicie:

```text
Apache
MySQL
```

---

### 5. Acesse o sistema

Abra o navegador e acesse o endereço correspondente ao diretório do projeto.

Exemplo:

```text
http://localhost/registro-de-frota/
```

---

## 🖥️ Interface

A aplicação possui uma interface web para gerenciamento das informações.

A página principal apresenta seções para:

* Cadastro
* Motoristas
* Veículos
* Associação de motoristas
* Histórico

Os registros também apresentam seu status:

```text
Ativo
Inativo
```

---

## 📚 Objetivo acadêmico

Este projeto foi desenvolvido com o objetivo de aplicar conceitos de desenvolvimento de sistemas utilizando **PHP e Programação Orientada a Objetos**.

Durante o desenvolvimento foram aplicados conceitos como:

* Classes e objetos
* Encapsulamento
* Métodos
* Tipagem
* Exceções
* Separação de responsabilidades
* Repository
* Service
* PDO
* SQL
* Relacionamentos entre tabelas
* Chaves estrangeiras
* Validação de dados

---

## 👨‍💻 Autor

**Cauã Carlos Souza Braz**

Projeto desenvolvido para fins acadêmicos e de aprendizado em desenvolvimento de software.

---

## 📄 Licença

Este projeto foi desenvolvido para fins educacionais.
