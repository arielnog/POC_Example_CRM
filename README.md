### Teste de desenvolvimento Ballroom 2022

Fala dev, beleza? Para desenvolver, você precisa realizar um **clone** desse repositório para sua conta e no final, disponibilizar o link para visualização. 

É necessário que você como desenvolvedor escreva um **README** com toda a informação necessária para testarmos sua aplicação, 
bem como também usuário e senha caso exista, rotas criadas para o CRUD e afins.

Obs: Não se esqueça  de fazer o PR das suas implementações para a sua versão do repositório.

**Mensagem do CEO da USS Enterprise**:

```
Alô devs! 

Acabamos de aprovar o orçamento final para o desenvolvimento do Enterprise CRM!

```

**Mensagem da equipe de marketing da USS Enterprise**:
```
Quando você precisa de um CRM?

Quando você tem um negócio de sucesso e quando tem mais clientes do que é humanamente possível gerenciar manualmente.

O Enterprise CRM faz todo o trabalho para você, de forma rápida e com uma interface fácil de usar.

Quer saber o que é ainda MELHOR nisso? Você pode usá-lo em qualquer dispositivo!
```

**Mensagem do Tech Lead do seu squad**:
```
Hey bro! 

Dentro do diretório "database" consta o arquivo de criação do banco de dados do Enterprise CRM.

Essa estrutura de tabelas foi criada há muito tempo e você tem toda a liberdade de adicionar novas tabelas caso ache necessário.

Não se esqueça de ler atentamente todo o fluxo, regras e definições que foram solicitadas!

Go to the moon! 🚀
```

### Fluxo de funcionamento do Enterprise CRM
- _stage_: estágio em qual o contato se encontra dentro do fluxo de vendas, pondendo ser:
    - _lead_: todo contato entra no fluxo de vendas com esse stage
    - _opportunity_: contato que está no pipeline de _proposal_sent_, _negociation_, _meeting_booked_ ou _lost_
    - _customer_: contato que está no pipeline de _won_
- _status_: status em qual o contato se encontra dentro do fluxo de vendas, podendo ser:
    - _open_: todo contato que é cadastrado inicia-se com esse status
    - _in_progress_: quando o contato está em qualquer `pipeline`
- _pipeline_: processo do funil de vendas em que o contato se encontra:
    - _contacted_: vendedor entrou em contato com o contato
    - _lost_: vendedor marcou o contato como perdido no funil de vendas
    - _won_: vendedor marcou o contato como ganho no funil de vendas
    - _proposal_sent_: vendedor enviou uma proposta de negociação para o contato
    - _negociation_: vendedor está no processo de negocicação com o contato
    - _meeting_booked_: vendedor marcou uma reunião presencial ou online com o contato

- obrigatoriamente o contato deve entrar com o `pipeline` como **null** quando seu `status` é `open`
### Regras e validações
- Um contato é definido através de seu endereço de e-mail, ou seja, deve ser único dentro do CRM
- Exibição de erros (fica a critério do candidato de como exibir)
- Mitigação de erros em cenários básicos, como por exemplo visualizar os dados de um contato inexistente

### O que será analisado
- Soft skills
    - Capacidade de entendimento de um problema "grande" e transformá-lo em pequenos problemas a serem resolvidos
- Desenvolvimento
    - DRY (Don't Repeat Yourself)
    - SRP (Single Responsability Principle)
    - Estrutura do código
    - Qualidade do código
- Versionamento
    - Entendimento do Git
    - Entendimento do Git-flow
    - Utilização de branches, como feature branches
    - Commits para cada must have solicitado

### Ficaremos felizes se você fizer 🙂
- CRUD implementado com framework CodeIgniter
- Documentação de todas as rotas (pode ser no readme do repositório)
- Sistema de autenticação e autorização de um administrador e/ou vendedor

### Você poderá...
- Escolher qualquer tipo de framework CSS, template ou afins para facilitar o desenvolvimento visual do CRUD (caso você opte por desenvolver isso)
- Qualquer tipo de autenticação de usuário, como JWT, session e afins (caso opte por desenvolver a autenticação)