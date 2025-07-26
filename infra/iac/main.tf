
provider "aws" {
  region = var.region
}

resource "aws_vpc" "xpe_vpc" {
  cidr_block           = var.vpc_cidr
  enable_dns_support   = true
  enable_dns_hostnames = true

  tags = merge(var.project_tags, { Name = "xpecloud-vpc" })
}

resource "aws_subnet" "xpe_subnet_public" {
  vpc_id                  = aws_vpc.xpe_vpc.id
  cidr_block              = var.subnet_public_cidr
  availability_zone       = var.availability_zone
  map_public_ip_on_launch = true

  tags = merge(var.project_tags, { Name = "xpecloud-subnet-public" })
}

resource "aws_subnet" "xpe_subnet_private" {
  vpc_id            = aws_vpc.xpe_vpc.id
  cidr_block        = var.subnet_private_cidr
  availability_zone = var.availability_zone

  tags = merge(var.project_tags, { Name = "xpecloud-subnet-private" })
}

resource "aws_internet_gateway" "xpe_igw" {
  vpc_id = aws_vpc.xpe_vpc.id

  tags = merge(var.project_tags, { Name = "xpecloud-igw" })
}

resource "aws_route_table" "xpe_public_rt" {
  vpc_id = aws_vpc.xpe_vpc.id

  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.xpe_igw.id
  }

  tags = merge(var.project_tags, { Name = "xpecloud-public-rt" })
}

resource "aws_route_table_association" "xpe_public_assoc" {
  subnet_id      = aws_subnet.xpe_subnet_public.id
  route_table_id = aws_route_table.xpe_public_rt.id
}

resource "aws_security_group" "xpe_sg_ec2" {
  name        = "xpecloud-sg-ec2"
  description = "Allow SSH and HTTP"
  vpc_id      = aws_vpc.xpe_vpc.id

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = merge(var.project_tags, { Name = "xpecloud-sg-ec2" })
}

resource "aws_security_group" "xpe_sg_rds" {
  name        = "xpecloud-sg-rds"
  description = "Allow MySQL from EC2"
  vpc_id      = aws_vpc.xpe_vpc.id

  ingress {
    from_port       = 3306
    to_port         = 3306
    protocol        = "tcp"
    security_groups = [aws_security_group.xpe_sg_ec2.id]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = merge(var.project_tags, { Name = "xpecloud-sg-rds" })
}

resource "aws_instance" "xpe_ec2_web" {
  ami                    = var.ami_id
  instance_type          = var.instance_type
  subnet_id              = aws_subnet.xpe_subnet_public.id
  key_name               = var.key_pair_name
  vpc_security_group_ids = [aws_security_group.xpe_sg_ec2.id]

  tags = merge(var.project_tags, { Name = "xpecloud-ec2" })
}

resource "aws_db_instance" "xpe_rds_mysql" {
  identifier              = "xpecloud-rds"
  engine                  = "mysql"
  engine_version          = "8.0"
  instance_class          = "db.t3.micro"
  allocated_storage       = 20
  username                = var.db_username
  password                = var.db_password
  db_subnet_group_name    = aws_db_subnet_group.xpe_rds_subnet_group.name
  vpc_security_group_ids  = [aws_security_group.xpe_sg_rds.id]
  skip_final_snapshot     = true
  publicly_accessible     = false

  tags = merge(var.project_tags, { Name = "xpecloud-rds" })
}

resource "aws_db_subnet_group" "xpe_rds_subnet_group" {
  name       = "xpecloud-db-subnet-group"
  subnet_ids = [aws_subnet.xpe_subnet_private.id]

  tags = merge(var.project_tags, { Name = "xpecloud-db-subnet-group" })
}
