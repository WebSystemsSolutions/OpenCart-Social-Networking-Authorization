CREATE TABLE `oc_oauth` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `token_password` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `id_auth` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oc_oauth`
--
ALTER TABLE `oc_oauth`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oc_oauth`
--
ALTER TABLE `oc_oauth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `oc_url_alias` (`query`, `keyword`) VALUES ('auth/oauth/glogin','glogin');




