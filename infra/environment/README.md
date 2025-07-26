# Projeto POC - Deploy WordPress com Ansible — Pós-graduação XP Educação

Este projeto é uma prova de conceito (PoC) que automatiza o provisionamento de um servidor Apache com suporte a PHP 8, fazendo o deploy de uma aplicação WordPress com o plugin Jetpack CRM, utilizando Ansible.

---

## 🎯 Objetivo

Automatizar os seguintes passos em uma instância EC2 da AWS:

- Instalação do Apache e bibliotecas PHP 8
- Clonagem do repositório WordPress com Jetpack CRM
- Deploy da aplicação na pasta padrão do Apache (`/var/www/html`)

---

## 📂 Estrutura esperada

Você deve criar os seguintes arquivos:

### `inventory.ini`

Define o IP público da instância EC2 e os dados de acesso via SSH.

Exemplo:

```ini
[web]
ec2-xx-xx-xx-xx.compute-1.amazonaws.com ansible_user=ubuntu ansible_ssh_private_key_file=~/.ssh/sua-chave.pem
