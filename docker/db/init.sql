-- CREATE USER IF NOT EXISTS pavel;
-- CREATE DATABASE teacher_selector;

DO
$$
    BEGIN
        IF NOT EXISTS (
            SELECT FROM pg_catalog.pg_roles WHERE rolname = 'pavel'
        ) THEN
            CREATE ROLE pavel LOGIN;
        END IF;
    END
$$;

DO
$$
    BEGIN
        IF NOT EXISTS (
            SELECT FROM pg_database WHERE datname = 'teacher_selector'
        ) THEN
            CREATE DATABASE teacher_selector;
        END IF;
    END
$$;

GRANT ALL PRIVILEGES ON DATABASE teacher_selector TO pavel;