
output "ec2_public_ip" {
  value       = aws_instance.xpe_ec2_web.public_ip
  description = "IP público da instância EC2 WordPress"
}

output "rds_endpoint" {
  value       = aws_db_instance.xpe_rds_mysql.endpoint
  description = "Endpoint do banco de dados RDS MySQL"
}
