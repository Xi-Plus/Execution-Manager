CREATE TABLE `log_run` (
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` char(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `log_task` (
  `name` char(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `task` (
  `path` char(255) NOT NULL,
  `source` text NOT NULL,
  `isrun` tinyint(1) NOT NULL DEFAULT '1',
  `token` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

