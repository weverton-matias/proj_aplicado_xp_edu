
variable "region" {
  default = "us-east-1"
}

variable "vpc_cidr" {
  default = "10.0.0.0/16"
}

variable "subnet_public_cidr" {
  default = "10.0.1.0/24"
}

variable "subnet_private_cidr" {
  default = "10.0.2.0/24"
}

variable "availability_zone" {
  default = "us-east-1a"
}

variable "instance_type" {
  default = "t2.micro"
}

variable "ami_id" {
  default = "ami-0c2b8ca1dad447f8a"
}

variable "key_pair_name" {
  default = "xpe-key"
}

variable "db_username" {
  default = "admin"
}

variable "db_password" {
  default = "XpeSenha123"
}

variable "project_tags" {
  default = {
    Projeto  = "xpecloud"
    Ambiente = "prova-conceito"
  }
}
