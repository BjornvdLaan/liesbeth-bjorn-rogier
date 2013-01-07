<?php

include ( '../../modules/constants.php');
include ( '../../app_client/_config.php');
include ( '../../modules/config.php');
include ( '../../modules/sources.php');
include ( '../../modules/IKE/class.php');

$context = stream_context_create(array('http' => array('header' => 'Connection: close\r\n')));


$scrapeId = array(
  array('youtube_id' => '-1jPUB7gRyg'),
  array('youtube_id' => '-m4QgmU4zts'),
  array('youtube_id' => '-oqAU5VxFWs'),
  array('youtube_id' => '-w4JGHB2o6I'),
  array('youtube_id' => '-wRQlUY5Xmo'),
  array('youtube_id' => '0cbKFLpj3oY'),
  array('youtube_id' => '0GbMiZV4l0Y'),
  array('youtube_id' => '0kcXP8mSUkM'),
  array('youtube_id' => '0mYBSayCsH0'),
  array('youtube_id' => '0RaLEVmuM4o'),
  array('youtube_id' => '14PgWitIbSk'),
  array('youtube_id' => '17ozSeGw-fY'),
  array('youtube_id' => '1b-mUxSl2TM'),
  array('youtube_id' => '1G4isv_Fylg'),
  array('youtube_id' => '1lI30Qw69AQ'),
  array('youtube_id' => '1lyu1KKwC74'),
  array('youtube_id' => '1plPyJdXKIY'),
  array('youtube_id' => '1tHCe7yW3UY'),
  array('youtube_id' => '1UUYjd2rjsE'),
  array('youtube_id' => '1Uw6ZkbsAH8'),
  array('youtube_id' => '1zfzka5VwRc'),
  array('youtube_id' => '22tCsudyU2E'),
  array('youtube_id' => '2bZuwbU0RBM'),
  array('youtube_id' => '2DQla5j26Qc'),
  array('youtube_id' => '2FrYnqk9xWU'),
  array('youtube_id' => '2H5uWRjFsGc'),
  array('youtube_id' => '2VlfQE_Nz38'),
  array('youtube_id' => '3moLkjvhEu0'),
  array('youtube_id' => '3oMhN4Jrdzk'),
  array('youtube_id' => '3U72hzeBLOw'),
  array('youtube_id' => '3YxaaGgTQYM'),
  array('youtube_id' => '44_wSqe4Qn8'),
  array('youtube_id' => '4fndeDfaWCg'),
  array('youtube_id' => '4GuqB1BQVr4'),
  array('youtube_id' => '4JKAid8Z-rA'),
  array('youtube_id' => '4vvBAONkYwI'),
  array('youtube_id' => '51iquRYKPbs'),
  array('youtube_id' => '53OU7q8Xo4w'),
  array('youtube_id' => '5anLPw0Efmo'),
  array('youtube_id' => '5FJO6b8GL3M'),
  array('youtube_id' => '5IoedEgydRo'),
  array('youtube_id' => '5P1neQKN-1k'),
  array('youtube_id' => '5rmKy8H62BU'),
  array('youtube_id' => '6cfCgLgiFDM'),
  array('youtube_id' => '6C_A8VZmZhs'),
  array('youtube_id' => '6Ejga4kJUts'),
  array('youtube_id' => '6g6g2mvItp4'),
  array('youtube_id' => '6rgStv12dwA'),
  array('youtube_id' => '6VJBBUqr1wM'),
  array('youtube_id' => '7epRPz0LGPE'),
  array('youtube_id' => '7gs2o5T7oN8'),
  array('youtube_id' => '7nqcL0mjMjw'),
  array('youtube_id' => '7QU1nvuxaMA'),
  array('youtube_id' => '7WlstnPwZ9g'),
  array('youtube_id' => '7Xf-Lesrkuc'),
  array('youtube_id' => '87XZWMmvBYg'),
  array('youtube_id' => '8mGBaXPlri8'),
  array('youtube_id' => '8N-qO3sPMjc'),
  array('youtube_id' => '8pmG4W0e1Vs'),
  array('youtube_id' => '8QSgNM9yNjo'),
  array('youtube_id' => '8s5ihWIywzg'),
  array('youtube_id' => '8SbUC-UaAxE'),
  array('youtube_id' => '8UVNT4wvIGY'),
  array('youtube_id' => '8WGPxai1YEU'),
  array('youtube_id' => '8WYHDfJDPDc'),
  array('youtube_id' => '8y8rbHuKTJw'),
  array('youtube_id' => '8yLG-lW_r_g'),
  array('youtube_id' => '8zu6dC8UGh4'),
  array('youtube_id' => '98GC8mG-t4k'),
  array('youtube_id' => '9bZkp7q19f0'),
  array('youtube_id' => '9ha5ujHnYXg'),
  array('youtube_id' => '9Ht5RZpzPqw'),
  array('youtube_id' => '9ldOuVuas1c'),
  array('youtube_id' => '9muzyOd4Lh8'),
  array('youtube_id' => '9NmGDZMy3G0'),
  array('youtube_id' => '9R-LV1U27Pk'),
  array('youtube_id' => '9sTQ0QdkN3Q'),
  array('youtube_id' => '9x4JZOm29Po'),
  array('youtube_id' => '9_aUaiCXtJE'),
  array('youtube_id' => 'A5A6mf0uCDk'),
  array('youtube_id' => 'a9iZh5lV13M'),
  array('youtube_id' => 'aBt8fN7mJNg'),
  array('youtube_id' => 'Adgx9wt63NY'),
  array('youtube_id' => 'AEYN5w4T_aM'),
  array('youtube_id' => 'Ahha3Cqe_fk'),
  array('youtube_id' => 'ahKF4e9Ct7U'),
  array('youtube_id' => 'aHV7LpNKkyM'),
  array('youtube_id' => 'aKHN0qnWsO8'),
  array('youtube_id' => 'Aknedws1g94'),
  array('youtube_id' => 'alUdIFc8fb0'),
  array('youtube_id' => 'aU3Rk-Z9boM'),
  array('youtube_id' => 'AW1nK9qHBvQ'),
  array('youtube_id' => 'AWpsOqh8q0M'),
  array('youtube_id' => 'azdesKO7r4Q'),
  array('youtube_id' => 'B5pWjFgzaRA'),
  array('youtube_id' => 'Bag1gUxuU0g'),
  array('youtube_id' => 'bBb-J0hcBQA'),
  array('youtube_id' => 'BE9CXWV1alg'),
  array('youtube_id' => 'BEkeAvFeuLw'),
  array('youtube_id' => 'bESGLojNYSo'),
  array('youtube_id' => 'bg6QzPpttVU'),
  array('youtube_id' => 'bh8X6fU8FLQ'),
  array('youtube_id' => 'BiEEJds8JFE'),
  array('youtube_id' => 'bjgFH01k0gU'),
  array('youtube_id' => 'bKDdT_nyP54'),
  array('youtube_id' => 'BkTXaZ52doQ'),
  array('youtube_id' => 'BlRvE9dKWQc'),
  array('youtube_id' => 'bPD6YiBFG1Q'),
  array('youtube_id' => 'bpOR_HuHRNs'),
  array('youtube_id' => 'BR4yQFZK9YM'),
  array('youtube_id' => 'BXS1HBbv6eM'),
  array('youtube_id' => 'C-Naa1HXeDQ'),
  array('youtube_id' => 'C6z8pD_k71g'),
  array('youtube_id' => 'c8SFVh5ONQA'),
  array('youtube_id' => 'Cb24kLd459Y'),
  array('youtube_id' => 'CB25m0D7M4s'),
  array('youtube_id' => 'cB9JJIoAdYM'),
  array('youtube_id' => 'ccbU8zlmda0'),
  array('youtube_id' => 'CDl9ZMfj6aE'),
  array('youtube_id' => 'CdXesX6mYUE'),
  array('youtube_id' => 'cjVQ36NhbMk'),
  array('youtube_id' => 'Cn88p4vAwHk'),
  array('youtube_id' => 'CpkCWs2zSNY'),
  array('youtube_id' => 'CQP-etYU1ps'),
  array('youtube_id' => 'CSJXle3LP_Q'),
  array('youtube_id' => 'cSnkWzZ7ZAA'),
  array('youtube_id' => 'CSvFpBOe8eY'),
  array('youtube_id' => 'CTAud5O7Qqk'),
  array('youtube_id' => 'cxcfcuUcBHw'),
  array('youtube_id' => 'cyn7sfQT0NI'),
  array('youtube_id' => 'D7GW8TYCEG4'),
  array('youtube_id' => 'd8ekz_CSBVg'),
  array('youtube_id' => 'dBpfpvicESU'),
  array('youtube_id' => 'DksSPZTZES0'),
  array('youtube_id' => 'DL7-CKirWZE'),
  array('youtube_id' => 'dLhFDYQHDQY'),
  array('youtube_id' => 'DmeUuoxyt_E'),
  array('youtube_id' => 'Dn8vzTsnPps'),
  array('youtube_id' => 'DtQSu9J8ogI'),
  array('youtube_id' => 'dvf--10EYXw'),
  array('youtube_id' => 'e5gvSzbSMNg'),
  array('youtube_id' => 'ECIU3SQyUU4'),
  array('youtube_id' => 'eFelujeJE4M'),
  array('youtube_id' => 'EfFWX2vJ_vQ'),
  array('youtube_id' => 'eG-8qGysw8U'),
  array('youtube_id' => 'eimgRedLkkU'),
  array('youtube_id' => 'Ek0SgwWmF9w'),
  array('youtube_id' => 'ELNUIG4rgao'),
  array('youtube_id' => 'eM213aMKTHg'),
  array('youtube_id' => 'eM8Ss28zjcE'),
  array('youtube_id' => 'emGri7i8Y2Y'),
  array('youtube_id' => 'EmZvOhHF85I'),
  array('youtube_id' => 'eocCPDxKq1o'),
  array('youtube_id' => 'eP_eI5T_deU'),
  array('youtube_id' => 'EqQuihD0hoI'),
  array('youtube_id' => 'ERNeIxz79VU'),
  array('youtube_id' => 'EVBsypHzF3U'),
  array('youtube_id' => 'evXtrZrdQ3o'),
  array('youtube_id' => 'e_xmgAki9ZY'),
  array('youtube_id' => 'f0EQlIzPowM'),
  array('youtube_id' => 'F57P9C4SAW4'),
  array('youtube_id' => 'FAPtTS0TYtU'),
  array('youtube_id' => 'FC3y9llDXuM'),
  array('youtube_id' => 'fe4EK4HSPkI'),
  array('youtube_id' => 'ff0oWESdmH0'),
  array('youtube_id' => 'FH6L1T1CYYI'),
  array('youtube_id' => 'fJ9rUzIMcZQ'),
  array('youtube_id' => 'fLexgOxsZu0'),
  array('youtube_id' => 'fq-geJ9UwG4'),
  array('youtube_id' => 'fV4DiAyExN0'),
  array('youtube_id' => 'fWNaR-rxAic'),
  array('youtube_id' => 'G3F9p7oydGA'),
  array('youtube_id' => 'g6t8g6ka4W0'),
  array('youtube_id' => 'Gc2K10CrThw'),
  array('youtube_id' => 'gcC3BKOAjSM'),
  array('youtube_id' => 'gGdGFtwCNBE'),
  array('youtube_id' => 'GJCQDd4vYjg'),
  array('youtube_id' => 'gJEcoTRhSjU'),
  array('youtube_id' => 'gJLIiF15wjQ'),
  array('youtube_id' => 'gnhXHvRoUd0'),
  array('youtube_id' => 'gnq4dO8EdXc'),
  array('youtube_id' => 'GP2uRViuB2Q'),
  array('youtube_id' => 'GPKQX2pJGWo'),
  array('youtube_id' => 'gRwFRMGpTWg'),
  array('youtube_id' => 'GSBFehvLJDc'),
  array('youtube_id' => 'gWubhw8SoBE'),
  array('youtube_id' => 'GZXHBgjQjNM'),
  array('youtube_id' => 'H2jCbXiEQI4'),
  array('youtube_id' => 'h3Yrhv33Zb8'),
  array('youtube_id' => 'HBxt_v0WF6Y'),
  array('youtube_id' => 'hGc28ZMQEh8'),
  array('youtube_id' => 'HGl8K2e0qDA'),
  array('youtube_id' => 'HkhfL0pnMPQ'),
  array('youtube_id' => 'hLQl3WQQoQ0'),
  array('youtube_id' => 'hlYVB42d-lI'),
  array('youtube_id' => 'HpOSwhIwUjM'),
  array('youtube_id' => 'Hq5i-6cJMJs'),
  array('youtube_id' => 'hr88CIVvWSA'),
  array('youtube_id' => 'hSjIz8oQuko'),
  array('youtube_id' => 'hsTYev-jiII'),
  array('youtube_id' => 'hTdhXxxWREo'),
  array('youtube_id' => 'hxt41DyE9zU'),
  array('youtube_id' => 'hyPCC_mdwzE'),
  array('youtube_id' => 'i28UEoLXVFQ'),
  array('youtube_id' => 'IBH97ma9YiI'),
  array('youtube_id' => 'ih1945e4q7I'),
  array('youtube_id' => 'Ii3x4IFtol0'),
  array('youtube_id' => 'ILCNAln_7Z4'),
  array('youtube_id' => 'iP6XpLQM2Cs'),
  array('youtube_id' => 'IR7QIAMQMnE'),
  array('youtube_id' => 'iTxOKsyZ0Lw'),
  array('youtube_id' => 'IUSack4LKAk'),
  array('youtube_id' => 'IycZK4i1gUQ'),
  array('youtube_id' => 'iyr4zN34YQA'),
  array('youtube_id' => 'J-gYJBsln-w'),
  array('youtube_id' => 'J91ti_MpdHA'),
  array('youtube_id' => 'JDKGWaCglRM'),
  array('youtube_id' => 'jIBqzPaZpOc'),
  array('youtube_id' => 'jjnmICxvoVY'),
  array('youtube_id' => 'jLAr-WlxMZY'),
  array('youtube_id' => 'JRfuAukYTKg'),
  array('youtube_id' => 'Js-VUC2Wan4'),
  array('youtube_id' => 'JTEWlSTQ1RI'),
  array('youtube_id' => 'JTMVOzPPtiw'),
  array('youtube_id' => 'jwv-iRvyDZg'),
  array('youtube_id' => 'JZioV5d3osg'),
  array('youtube_id' => 'JZpxaiNV_sM'),
  array('youtube_id' => 'k0BWlvnBmIE'),
  array('youtube_id' => 'K38xNqZvBJI'),
  array('youtube_id' => 'k4V3Mo61fJM'),
  array('youtube_id' => 'KagvExF-ijc'),
  array('youtube_id' => 'KDHCVSgPxtI'),
  array('youtube_id' => 'KDKva-s_khY'),
  array('youtube_id' => 'kdvbD3vyMdA'),
  array('youtube_id' => 'KeOMA7lANmg'),
  array('youtube_id' => 'kfVsfOSbJY0'),
  array('youtube_id' => 'kHBXPoJhnHQ'),
  array('youtube_id' => 'kHg-PhseKOQ'),
  array('youtube_id' => 'Knf6ZsJFsG8'),
  array('youtube_id' => 'koJlIGDImiU'),
  array('youtube_id' => 'KRaWnd3LJfs'),
  array('youtube_id' => 'krw4l6WiN-A'),
  array('youtube_id' => 'kTHNpusq654'),
  array('youtube_id' => 'ktvTqknDobU'),
  array('youtube_id' => 'kYtGl1dX5qI'),
  array('youtube_id' => 'l-6--1GzCQA'),
  array('youtube_id' => 'L-iepu3EtyE'),
  array('youtube_id' => 'lAhHNCfA7NI'),
  array('youtube_id' => 'Lai6Edx6RuM'),
  array('youtube_id' => 'Lbtyif6s9ZA'),
  array('youtube_id' => 'LGM5GkINMMI'),
  array('youtube_id' => 'lNK9Hsqdn7w'),
  array('youtube_id' => 'LoQYw49saqc'),
  array('youtube_id' => 'LPgvNlrBfb0'),
  array('youtube_id' => 'LQj--Kjn0z8'),
  array('youtube_id' => 'lsV500W4BHU'),
  array('youtube_id' => 'Lt2wjJlP2N4'),
  array('youtube_id' => 'LtrkfgZYMgE'),
  array('youtube_id' => 'luUm96QlCs0'),
  array('youtube_id' => 'lWA2pjMjpBs'),
  array('youtube_id' => 'lwlogyj7nFE'),
  array('youtube_id' => 'LXR1pQ-HuvI'),
  array('youtube_id' => 'L_jWHffIx5E'),
  array('youtube_id' => 'M11SvDtPBhA'),
  array('youtube_id' => 'M4jxL9s_tDA'),
  array('youtube_id' => 'M5bBjiq8zb8'),
  array('youtube_id' => 'm8fm3Z7jgWM'),
  array('youtube_id' => 'mEqDKq_GkJE'),
  array('youtube_id' => 'MjwFe6okyUw'),
  array('youtube_id' => 'mk48xRzuNvA'),
  array('youtube_id' => 'MmukW1sNlIk'),
  array('youtube_id' => 'MN61l98ex_U'),
  array('youtube_id' => 'Mn6Em9g5I7w'),
  array('youtube_id' => 'MntbN1DdEP0'),
  array('youtube_id' => 'mvSvEeD8CVQ'),
  array('youtube_id' => 'MYxAiK6VnXw'),
  array('youtube_id' => 'N17FXwRWEZs'),
  array('youtube_id' => 'n3htOCjafTc'),
  array('youtube_id' => 'n4aELnPYCIc'),
  array('youtube_id' => 'N4f1svo5ATw'),
  array('youtube_id' => 'n8Eqgz3rL3k'),
  array('youtube_id' => 'N9SZaOJEWXU'),
  array('youtube_id' => 'NaGLVS5b_ZY'),
  array('youtube_id' => 'NARjr3fMMvY'),
  array('youtube_id' => 'NdYWuo9OFAw'),
  array('youtube_id' => 'nF7wa3j57j0'),
  array('youtube_id' => 'NGFSNE18Ywc'),
  array('youtube_id' => 'nhPaWIeULKk'),
  array('youtube_id' => 'njPWBTIv9qw'),
  array('youtube_id' => 'nkR9ELR6cpM'),
  array('youtube_id' => 'NmqK0aXkHho'),
  array('youtube_id' => 'NOubzHCUt48'),
  array('youtube_id' => 'NpILkBBve7k'),
  array('youtube_id' => 'NRtvqT_wMeY'),
  array('youtube_id' => 'Nx6vpZZw9e8'),
  array('youtube_id' => 'nXWzbsnb638'),
  array('youtube_id' => 'o38QCTzWxe4'),
  array('youtube_id' => 'O6XE1XRiLeY'),
  array('youtube_id' => 'Oai1V7kaFBk'),
  array('youtube_id' => 'Ob9dl7Sy2Cg'),
  array('youtube_id' => 'OeczcR5zKfo'),
  array('youtube_id' => 'OJ7oyx3C6Do'),
  array('youtube_id' => 'oqGnsP4wOf0'),
  array('youtube_id' => 'oRdxUFDoQe0'),
  array('youtube_id' => 'osZI1NDA33s'),
  array('youtube_id' => 'OT5msu-dap8'),
  array('youtube_id' => 'OTvc-bEP35I'),
  array('youtube_id' => 'oxqnFJ3lp5k'),
  array('youtube_id' => 'OYjZK_6i37M'),
  array('youtube_id' => 'p-Z3YrHJ1sU'),
  array('youtube_id' => 'P0wOuWy1lCk'),
  array('youtube_id' => 'p2Rch6WvPJE'),
  array('youtube_id' => 'P3CxhBIrBho'),
  array('youtube_id' => 'pa14VNsdSYM'),
  array('youtube_id' => 'pcrP33Shva0'),
  array('youtube_id' => 'PcWMD04_O_k'),
  array('youtube_id' => 'PDboaDrHGbA'),
  array('youtube_id' => 'pj6FCKm8dhM'),
  array('youtube_id' => 'pljEGIUO4ms'),
  array('youtube_id' => 'PpRa_abeA-w'),
  array('youtube_id' => 'pqky5B179nM'),
  array('youtube_id' => 'PWgvGjAhvIw'),
  array('youtube_id' => 'PwvwFsGIKtQ'),
  array('youtube_id' => 'PYgBX68Y6E4'),
  array('youtube_id' => 'Q3Yc3HhSl1Q'),
  array('youtube_id' => 'Q4dNjNaXpak'),
  array('youtube_id' => 'qaePWd0Wqq0'),
  array('youtube_id' => 'Qb4Q-2TueEM'),
  array('youtube_id' => 'qfNmyxV2Ncw'),
  array('youtube_id' => 'QfsmBfYX-80'),
  array('youtube_id' => 'qgeklMIc6_k'),
  array('youtube_id' => 'QGJuMBdaqIw'),
  array('youtube_id' => 'qGKrc3A6HHM'),
  array('youtube_id' => 'qjHlgrGsLWQ'),
  array('youtube_id' => 'QJO3ROT-A4E'),
  array('youtube_id' => 'QnU1-I9QNfo'),
  array('youtube_id' => 'Qok9Ialei4c'),
  array('youtube_id' => 'QOowQeKyNkQ'),
  array('youtube_id' => 'Qq4j1LtCdww'),
  array('youtube_id' => 'qQkBeOisNM0'),
  array('youtube_id' => 'qrO4YZeyl0I'),
  array('youtube_id' => 'QWbAaTDlBls'),
  array('youtube_id' => 'qxwry2qUwFs'),
  array('youtube_id' => 'Q_LPJllaogU'),
  array('youtube_id' => 'R2DglHU04rQ'),
  array('youtube_id' => 'r7SMwAyO1RY'),
  array('youtube_id' => 'RB-RcX5DS5A'),
  array('youtube_id' => 'Rbm6GXllBiw'),
  array('youtube_id' => 'rGLxRbPliFY'),
  array('youtube_id' => 'RiSfTyrvJlg'),
  array('youtube_id' => 'RJuKZdHyjo8'),
  array('youtube_id' => 'rJwVV0WznRc'),
  array('youtube_id' => 'RnBAS8sDt20'),
  array('youtube_id' => 'rn_YodiJO6k'),
  array('youtube_id' => 'ROr5uMpBDnk'),
  array('youtube_id' => 'rORPLLZzIwA'),
  array('youtube_id' => 'rOSvEWEesWo'),
  array('youtube_id' => 'rp4UwPZfRis'),
  array('youtube_id' => 'rsTFktSg1wg'),
  array('youtube_id' => 'rtOvBOTyX00'),
  array('youtube_id' => 'RUi54JTgL5s'),
  array('youtube_id' => 'rvHplpIkW_U'),
  array('youtube_id' => 'rxRvDpF2FDA'),
  array('youtube_id' => 'rYEDA3JcQqw'),
  array('youtube_id' => 'RYnFIRc0k6E'),
  array('youtube_id' => 's1tAYmMjLdY'),
  array('youtube_id' => 's8QYxmpuyxg'),
  array('youtube_id' => 's9MszVE7aR4'),
  array('youtube_id' => 'SBjQ9tuuTJQ'),
  array('youtube_id' => 'SbUBMklQSVU'),
  array('youtube_id' => 'sc5iTNVEOAg'),
  array('youtube_id' => 'SeIJmciN8mo'),
  array('youtube_id' => 'sFJnu2Pi8jQ'),
  array('youtube_id' => 'sg8L32v6dOQ'),
  array('youtube_id' => 'SkTt9k4Y-a8'),
  array('youtube_id' => 'sQcYGx_jzlU'),
  array('youtube_id' => 'sQghSEl0hHQ'),
  array('youtube_id' => 'SRiFCFbyCt8'),
  array('youtube_id' => 'sRYNYb30nxU'),
  array('youtube_id' => 'Su7Ew4kCFMk'),
  array('youtube_id' => 'Sv6dMFF_yts'),
  array('youtube_id' => 'swghsu7LXSs'),
  array('youtube_id' => 'SzsDHtzx6tI'),
  array('youtube_id' => 'SzT0dvNrFc4'),
  array('youtube_id' => 's_RGaSV0KIg'),
  array('youtube_id' => 'T-sxSd1uwoU'),
  array('youtube_id' => 't1ufVPjIGvM'),
  array('youtube_id' => 'T3E9Wjbq44E'),
  array('youtube_id' => 't4H_Zoh7G5A'),
  array('youtube_id' => 't5ocg3unVDk'),
  array('youtube_id' => 't5Sd5c4o9UM'),
  array('youtube_id' => 'T6wbugWrfLU'),
  array('youtube_id' => 'TcNMuOXQri4'),
  array('youtube_id' => 'TG8IkUoZ6j0'),
  array('youtube_id' => 'TGwZ7MNtBFU'),
  array('youtube_id' => 'TIy3n2b7V9k'),
  array('youtube_id' => 'tJTMGVps8JQ'),
  array('youtube_id' => 'tkwCYNaUIK0'),
  array('youtube_id' => 'TlDInVqv8cs'),
  array('youtube_id' => 'tMfXeuv4kZE'),
  array('youtube_id' => 'TPE9uSFFxrI'),
  array('youtube_id' => 'Tq8tK1rGpog'),
  array('youtube_id' => 'TR3Vdo5etCQ'),
  array('youtube_id' => 'TSNerxNwWtU'),
  array('youtube_id' => 'TTA2buWlNyM'),
  array('youtube_id' => 'TUszotxuwGo'),
  array('youtube_id' => 'tWbLkXhGEmo'),
  array('youtube_id' => 'tYTwIZslZXo'),
  array('youtube_id' => 'u1fSSruXPCY'),
  array('youtube_id' => 'U3H__YM7Zbc'),
  array('youtube_id' => 'UBGxYfQ7Gy0'),
  array('youtube_id' => 'UculXjdcSYs'),
  array('youtube_id' => 'Ug88HO2mg44'),
  array('youtube_id' => 'uhG-vLZrb-g'),
  array('youtube_id' => 'ui1tUS6Ho-c'),
  array('youtube_id' => 'uI6VfwBV8Gc'),
  array('youtube_id' => 'UIt9tPBo5i0'),
  array('youtube_id' => 'UJtB55MaoD0'),
  array('youtube_id' => 'up7pvPqNkuU'),
  array('youtube_id' => 'UqXVgAmqBOs'),
  array('youtube_id' => 'uuwfgXD8qV8'),
  array('youtube_id' => 'V8ehThdbXJs'),
  array('youtube_id' => 'VA770wpLX-Q'),
  array('youtube_id' => 'vdrqA93sW-8'),
  array('youtube_id' => 'Vf78alvpxRM'),
  array('youtube_id' => 'vLWXbQsctMw'),
  array('youtube_id' => 'vM7F4XA7nsU'),
  array('youtube_id' => 'VRPxao3e_jY'),
  array('youtube_id' => 'VuNIsY6JdUw'),
  array('youtube_id' => 'VV1XWJN3nJo'),
  array('youtube_id' => 'vx2u5uUu3DE'),
  array('youtube_id' => 'v_guSWwIbNQ'),
  array('youtube_id' => 'w6dpooV4tlQ'),
  array('youtube_id' => 'w9ZQ7Rese70'),
  array('youtube_id' => 'WDp6cqnihwU'),
  array('youtube_id' => 'WeYsTmIzjkw'),
  array('youtube_id' => 'WMv8GXhxjCU'),
  array('youtube_id' => 'WQnAxOQxQIU'),
  array('youtube_id' => 'wyJ9CblhZmg'),
  array('youtube_id' => 'X100o6AttnQ'),
  array('youtube_id' => 'x4AmkD0xnp4'),
  array('youtube_id' => 'x97t-ZhqMc0'),
  array('youtube_id' => 'xat1GVnl8-k'),
  array('youtube_id' => 'XBZ6A-Jkbk8'),
  array('youtube_id' => 'xGPeNN9S0Fg'),
  array('youtube_id' => 'xGytDsqkQY8'),
  array('youtube_id' => 'XIlkcIh_Q_U'),
  array('youtube_id' => 'XIVCb459bkQ'),
  array('youtube_id' => 'XjVNlG5cZyQ'),
  array('youtube_id' => 'XmpDIUqxl7Y'),
  array('youtube_id' => 'XoroTFH6Iv4'),
  array('youtube_id' => 'xPU8OAjjS4k'),
  array('youtube_id' => 'xVK9emHIDYM'),
  array('youtube_id' => 'xwtdhWltSIg'),
  array('youtube_id' => 'xyqQ4iT4IeU'),
  array('youtube_id' => 'Y1xs_xPb46M'),
  array('youtube_id' => 'Y9IsJ2MYKQI'),
  array('youtube_id' => 'ydpfUuwpnx0'),
  array('youtube_id' => 'YeqOLxRDsV8'),
  array('youtube_id' => 'yERDDbP53Sw'),
  array('youtube_id' => 'YfjTZLxekig'),
  array('youtube_id' => 'YgSPaXgAdzE'),
  array('youtube_id' => 'YI4m-l2yRZA'),
  array('youtube_id' => 'yK02XqkdFF8'),
  array('youtube_id' => 'YlUKcNNmywk'),
  array('youtube_id' => 'Ypkv0HeUvTc'),
  array('youtube_id' => 'Ys7-6_t7OEQ'),
  array('youtube_id' => 'YVkUvmDQ3HY'),
  array('youtube_id' => 'YxmxZc0dNv4'),
  array('youtube_id' => 'Z5k1U8EAGxA'),
  array('youtube_id' => 'z5OXON8vIaA'),
  array('youtube_id' => 'z9E4Nl2d60U'),
  array('youtube_id' => 'zA52uNzx7Y4'),
  array('youtube_id' => 'ZaI2IlHwmgQ'),
  array('youtube_id' => 'zaVhipqTY9I'),
  array('youtube_id' => 'zD0zrYsG0sg'),
  array('youtube_id' => 'zHhhPpjeoi0'),
  array('youtube_id' => 'zlt9QmJFEz4'),
  array('youtube_id' => 'zqKZ_WIK5ms'),
  array('youtube_id' => 'ZqTqZAingM4'),
  array('youtube_id' => 'ZWfRnMOFKzo'),
  array('youtube_id' => 'ZyhrYis509A'),
  array('youtube_id' => 'zYxkezUr8MQ'),
  array('youtube_id' => 'zzH-RaANzK4'),
  array('youtube_id' => 'Zzyfcys1aLM'),
  array('youtube_id' => '_bISJ2zi1zQ'),
  array('youtube_id' => '_HkL8GuU9_0'),
  array('youtube_id' => '_mUjgAHROTU'),
  array('youtube_id' => '_nExce26tXs'),
  array('youtube_id' => '_ovdm2yX4MA'),
  array('youtube_id' => '_qXFWz2j0p8')
);

$toScrape = array(
    'http://www.youtube.com/watch?v=TIy3n2b7V9k',
    'http://www.youtube.com/watch?v=_aARooQAfy8',
    'http://www.youtube.com/watch?v=7kVNl-9cS9c',
    'http://www.youtube.com/watch?v=5OoihTVlcUY',
    'http://www.youtube.com/watch?v=4T9-54o4DzE',
    'http://www.youtube.com/watch?v=NB58B2Gn3CU',
    'http://www.youtube.com/watch?v=hGc28ZMQEh8',
    'http://www.youtube.com/watch?v=JxZcFArCeKs',
    'http://www.youtube.com/watch?v=ISETbQws10Q',
    'http://www.youtube.com/watch?v=4fndeDfaWCg',
    'http://www.youtube.com/watch?v=ulOb9gIGGd0',
    'http://www.youtube.com/watch?v=qFYaImiDnEE',
    'http://www.youtube.com/watch?v=ZyhrYis509A',
    'http://www.youtube.com/watch?v=1G4isv_Fylg',
    'http://www.youtube.com/watch?v=PVzljDmoPVs',
    'http://www.youtube.com/watch?v=BJ-CmHZrKHU',
    'http://www.youtube.com/watch?v=KlyXNRrsk4A',
    'http://www.youtube.com/watch?v=bW6PowAIAxg',
    'http://www.youtube.com/watch?v=oABEGc8Dus0',
    'http://www.youtube.com/watch?v=fWNaR-rxAic',
    'http://www.youtube.com/watch?v=2Z4m4lnjxkY',
    'http://www.youtube.com/watch?v=uE-1RPDqJAY',
    'http://www.youtube.com/watch?v=dQw4w9WgXcQ',
    'http://www.youtube.com/watch?v=GKeXHCOEZ1k',
    'http://www.youtube.com/watch?v=kNPcxp2sMQQ',
    'http://www.youtube.com/watch?v=hMtZfW2z9dw',
    'http://www.youtube.com/watch?v=dVPCYr3XDPg',
    'http://www.youtube.com/watch?v=XHEFbX81XWQ',
    'http://www.youtube.com/watch?v=0w6c9zHFfCg',
    'http://www.youtube.com/watch?v=6FgDXAUYqHg',
    'http://www.youtube.com/watch?v=UculXjdcSYs',
    'http://www.youtube.com/watch?v=SeIJmciN8mo',
    'http://www.youtube.com/watch?v=6FgDXAUYqHg',
    'http://www.youtube.com/watch?v=BJ-CmHZrKHU',
    'http://www.youtube.com/watch?v=s4rzYABlH5o',
    'http://www.youtube.com/watch?v=j0lSpNtjPM8',
    'http://www.youtube.com/watch?v=tAp9BKosZXs',
    'http://www.youtube.com/watch?v=1usGCnVqIqA',
    'http://www.youtube.com/watch?v=w8KQmps-Sog',
    'http://www.youtube.com/watch?v=w15oWDh02K4',
    'http://www.youtube.com/watch?v=sL5Mz-H7_w8'
);

if (true) {
    $i = 1;
    foreach ($scrapeId as $yt) {
        $link = sprintf('http://www.rogierslag.nl/video?link=%s', sprintf('%s%s', urlencode('http://www.youtube.com/watch?v='), $yt['youtube_id']));
        $data = file_get_contents($link, false, $context);
        echo 'Woosh  #' . $i . '  ' . $link . CHAR_NL;
        $i++;
    }
    die('terminated');
}

$visited = array();
$j = 0;
header('Content-type: text/plain');
for ($i = 0; isset($sc[$i]) && $j < 10000; $i++) {
    echo CHAR_NL . CHAR_NL . 'new mainlink';
    $data = file_get_contents($toScrape[$i]);
    $parser = new simple_html_dom();
    $parser->load($data);
    $aDingen = $parser->find('a');

    foreach ($aDingen as $link) {
        $link = $link->__get('outertext');
        $match = array();
        preg_match('/"\/watch\?v=([a-zA-Z0-9\-_]*)"/', $link, $match);
        if (isset($match[0])) {
            $match = sprintf('http://www.youtube.com%s', substr($match[0], 1, -1));
            if (in_array($match, $visited)) {
                continue;
            }
            echo CHAR_NL . $match . ' #' . $j;
            $args = array('link' => $match);
            file_get_contents(sprintf('http://ike.rogierslag.nl/video?link=%s', $match), false, $context);
            usleep(200);
            $toScrape[] = $match;
            $visited[] = $match;
            $j++;
        }
    }
}

function doPost($url, $args, $port, $cookie = '') {
    $args = http_build_query($args);
    $url = parse_url($url);

    # Host info destilleren
    $host = $url['host'];
    $path = $url['path'];

    # Socket
    $fp = fsockopen($host, $port, $errno, $errstr, 10);

    if ($fp) {
        // send the request headers:
        fputs($fp, "POST " . $path . " HTTP/1.1\r\n");
        fputs($fp, "Host: " . $host . "\r\n");

        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: " . strlen($args) . "\r\n");
        fputs($fp, "Cookie: " . $cookie . "\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $args);

        $result = '';
        while (!feof($fp))
            $result .= fgets($fp, 128);
    } else {
        return array(
            'status' => 'err',
            'error' => $errstr . " (" . $errno . ")"
        );
    }

    fclose($fp);

    # Header en content scheiden
    $result = explode("\r\n\r\n", $result, 2);

    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';

    // return as structured array:
    return array(
        'status' => 'ok',
        'header' => $header,
        'content' => $content
    );
}