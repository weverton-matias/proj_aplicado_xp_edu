# Projeto Aplicado - Pós-graduação em Cloud Computing  
## Faculdade XP Educação

---

## 1. Contexto

Este projeto faz parte da pós-graduação em Cloud Computing da Faculdade XP Educação. Tem como objetivo aplicar conhecimentos práticos e conceituais em computação em nuvem para a criação de uma infraestrutura automatizada, escalável e segura para hospedagem de uma aplicação web WordPress integrada com o plugin Jetpack CRM.

---

## 2. Objetivos

- Provisionar infraestrutura na AWS utilizando Terraform para garantir consistência e reprodutibilidade.
- Automatizar o deploy da aplicação WordPress com Ansible, incluindo instalação do Apache, PHP 8 e configuração do ambiente.
- Utilizar boas práticas de DevOps para integração contínua e entrega contínua (CI/CD).
- Criar ambiente seguro com separação de subnets públicas e privadas, controlando o acesso entre recursos.
- Documentar todo o processo para replicabilidade e avaliação acadêmica.

---

## 3. Arquitetura do Projeto

- **Infraestrutura (IaC)**: Terraform para provisionar VPC, subnets, instância EC2 e RDS MySQL.
- **Configuração do Servidor**: Ansible para instalar pacotes, configurar Apache, PHP e fazer deploy do código.
- **Repositórios Git**:
  - `/app/wordpress`: Código da aplicação WordPress com Jetpack CRM.
  - `/app/infra/iac`: Código Terraform.
  - `/app/infra/environment`: Playbooks Ansible.
- **Pipeline CI/CD**: Github Actions para automatizar deploy e testes.

---

## 4. Tecnologias Utilizadas

- AWS (EC2, RDS, VPC)
- Terraform
- Ansible
- Apache HTTP Server
- PHP 8
- MySQL 8
- GitHub Actions
- WordPress + Jetpack CRM
