# Projeto POC AWS com Terraform — Pós-graduação XP Educação

Este projeto é uma prova de conceito (PoC) para provisionamento de uma infraestrutura simples na AWS utilizando Terraform.

## 🎯 Objetivo

Criar a seguinte estrutura:

- VPC customizada com subnets pública e privada
- EC2 na subnet pública (Apache instalado para rodar PHP)
- RDS MySQL 8.0 na subnet privada
- Grupos de segurança adequados para cada componente

---

## 📂 Estrutura esperada

Você deve criar o seguinte arquivo:

### `terraform.tfvars` (**não deve ser versionado**)

Arquivo local que contém os **valores reais** das variáveis. Exemplo de conteúdo:

```hcl
project_name        = "xpecloud"
region              = "us-east-1"
vpc_cidr_block      = "10.0.0.0/16"
public_subnet_cidr  = "10.0.1.0/24"
private_subnet_cidr = "10.0.2.0/24"
ec2_key_name        = "minha-chave-ec2.pem"
db_username         = "admin"
db_password         = "senhaSegura123"
```
