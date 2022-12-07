--
-- チームメンバーテーブル作成
--
CREATE TABLE IF NOT EXISTS team_members (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'チームメンバーID',
    team_id INT(11) NOT NULL COMMENT 'チームID',
    user_id INT(11) COMMENT 'ユーザーID',
    email VARCHAR(255) COMMENT '招待メールアドレス',
    role_code INT(1) NOT NULL DEFAULT 0 COMMENT '権限コード(0:一般,1:管理者)',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
);