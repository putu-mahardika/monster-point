<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecEventProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            CREATE OR ALTER PROCEDURE sp_ExecEvent
                @token VARCHAR(100),
                @idmember BIGINT,
                @event VARCHAR(50),
                @value FLOAT
            AS
            DECLARE @idMerchant BIGINT,
                    @syntax NVARCHAR(1000),
                    @daily BIT,
                    @once BIT,
                    @point FLOAT,
                    @idevent BIGINT,
                    @Memberaktif INT,
                    @newGuid UNIQUEIDENTIFIER,
                    @Isdaily INT,
                    @IsOnce INT,
                    @lastPointMember FLOAT;
            BEGIN
                SET @newGuid = NEWID();
                SET @event = UPPER(@event);
                BEGIN TRY
                    --- pengecekan merchant
                    SELECT @idMerchant = Id
                    FROM dbo.Merchant
                    WHERE UPPER(Token) = UPPER(@token)
                        AND Akif = 1
                        AND Validasi = 1;
                    IF @idMerchant IS NULL
                    BEGIN
                        EXEC dbo.sp_Log @Guid = @newGuid,                                 -- uniqueidentifier
                                        @IdMerchant = 0,                                  -- bigint
                                        @IdMember = 0,                                    -- bigint
                                        @IdEvent = 0,                                     -- bigint
                                        @Node = 'Token',                                  -- varchar(150)
                                        @Keterangan = 'Token Merchant Tidak Ditemukan !', -- varchar(250)
                                        @Point = 0,                                       -- float
                                        @Status = 400,                                    -- int
                                        @Daily = NULL,
                                        @OnceTime = NULL,
                                        @Attribute1 = NULL,                               -- varchar(150)
                                        @Attribute2 = NULL,                               -- varchar(150)
                                        @Attribute3 = NULL;                               -- varchar(150)
                    END;
                    ELSE
                    BEGIN
                        --- untuk pengecekan member
                        SELECT @Memberaktif = COUNT(Id),
                            @lastPointMember = Point
                        FROM dbo.Member
                        WHERE IdMerhant = @idMerchant
                            AND Aktif = 1
                            AND Id = @idmember
                        GROUP BY Point;
                        -----------------------------------------------------
                        IF ISNULL(@Memberaktif, 0) = 0
                        BEGIN

                            EXEC dbo.sp_Log @Guid = @newGuid,                         -- uniqueidentifier
                                            @IdMerchant = @idMerchant,                -- bigint
                                            @IdMember = 0,                            -- bigint
                                            @IdEvent = 0,                             -- bigint
                                            @Node = 'Member',                         -- varchar(150)
                                            @Keterangan = 'Member Tidak Ditemukan !', -- varchar(250)
                                            @Point = 0,                               -- float
                                            @Status = 400,                            -- int
                                            @Daily = NULL,
                                            @OnceTime = NULL,
                                            @Attribute1 = NULL,                       -- varchar(150)
                                            @Attribute2 = NULL,                       -- varchar(150)
                                            @Attribute3 = NULL;                       -- varchar(150)

                        END;
                        ELSE
                        BEGIN
                            --- pengecekan event
                            SELECT @idevent = Id,
                                @syntax = Formula,
                                @daily = Daily,
                                @once = OnceTime
                            FROM dbo.Events
                            WHERE IdMerchant = @idMerchant
                                AND Aktif = 1
                                AND Kode = @event;
                            IF ISNULL(@idevent, 0) = 0
                            BEGIN
                                --- kondisi event tidak ada
                                EXEC dbo.sp_Log @Guid = @newGuid,                        -- uniqueidentifier
                                                @IdMerchant = @idMerchant,               -- bigint
                                                @IdMember = @idmember,                   -- bigint
                                                @IdEvent = 0,                            -- bigint
                                                @Node = 'Event',                         -- varchar(150)
                                                @Keterangan = 'Event Tidak Ditemukan !', -- varchar(250)
                                                @Point = 0,                              -- float
                                                @Status = 400,                           -- int
                                                @Daily = NULL,
                                                @OnceTime = NULL,
                                                @Attribute1 = NULL,                      -- varchar(150)
                                                @Attribute2 = NULL,                      -- varchar(150)
                                                @Attribute3 = NULL;                      -- varchar(150)
                            END;
                            ELSE
                            BEGIN
                                --- Kondisi formula didapatkan ------------------------
                                SET @syntax =
                                (
                                    SELECT dbo.fcSecureSql(@syntax)
                                );
                                SET @syntax = N' SELECT @point =( ' + UPPER(@syntax) + N')';

                                --- Excute Formula --------
                                EXECUTE sp_executesql @syntax,
                                                    N'@value FLOAT, @point FLOAT OUTPUT',
                                                    @value = @value,
                                                    @point = @point OUTPUT;
                                --------------------------------------------------------
                                --- pengecekan point member
                                IF ISNULL(@lastPointMember, 0) + @point < 0
                                BEGIN
                                    EXEC dbo.sp_Log @Guid = @newGuid,                                -- uniqueidentifier
                                                    @IdMerchant = @idMerchant,                       -- bigint
                                                    @IdMember = @idmember,                           -- bigint
                                                    @IdEvent = @idevent,                             -- bigint
                                                    @Node = @event,                                  -- varchar(150)
                                                    @Keterangan = 'Point Member Tidak Mencukupin !', -- varchar(250)
                                                    @Point = 0,                                      -- float
                                                    @Status = 400,                                   -- int
                                                    @Daily = NULL,
                                                    @OnceTime = 1,
                                                    @Attribute1 = NULL,                              -- varchar(150)
                                                    @Attribute2 = NULL,                              -- varchar(150)
                                                    @Attribute3 = NULL;                              -- varchar(150)
                                END;
                                --------------------------------------------------------
                                ELSE
                                BEGIN
                                    IF ISNULL(@once, 0) = 1
                                    AND ISNULL(@daily, 0) = 0
                                    BEGIN
                                        --- mendaptkan log terlebih dahulu
                                        SELECT @IsOnce = COUNT(Id)
                                        FROM dbo.Log
                                        WHERE IdMerchant = @idMerchant
                                            AND IdMember = @idmember
                                            AND OnceTime = 1;
                                        IF ISNULL(@IsOnce, 0) = 0
                                        BEGIN
                                            BEGIN TRANSACTION;
                                            UPDATE dbo.Member
                                            SET Point = ISNULL(Point, 0) + @point
                                            WHERE IdMerhant = @idMerchant
                                                AND Id = @idmember;
                                            COMMIT;
                                            EXEC dbo.sp_Log @Guid = @newGuid,          -- uniqueidentifier
                                                            @IdMerchant = @idMerchant, -- bigint
                                                            @IdMember = @idmember,     -- bigint
                                                            @IdEvent = @idevent,       -- bigint
                                                            @Node = @event,            -- varchar(150)
                                                            @Keterangan = 'Sukses !',  -- varchar(250)
                                                            @Point = @point,           -- float
                                                            @Status = 200,             -- int
                                                            @Daily = NULL,
                                                            @OnceTime = 1,
                                                            @Attribute1 = NULL,        -- varchar(150)
                                                            @Attribute2 = NULL,        -- varchar(150)
                                                            @Attribute3 = NULL;        -- varchar(150)
                                        END;
                                        ELSE
                                        BEGIN
                                            EXEC dbo.sp_Log @Guid = @newGuid,                                -- uniqueidentifier
                                                            @IdMerchant = @idMerchant,                       -- bigint
                                                            @IdMember = @idmember,                           -- bigint
                                                            @IdEvent = 0,                                    -- bigint
                                                            @Node = @event,                                  -- varchar(150)
                                                            @Keterangan = 'Event Sudah Didapatkan Member !', -- varchar(250)
                                                            @Point = 0,                                      -- float
                                                            @Status = 400,                                   -- int
                                                            @Daily = NULL,
                                                            @OnceTime = NULL,
                                                            @Attribute1 = NULL,                              -- varchar(150)
                                                            @Attribute2 = NULL,                              -- varchar(150)
                                                            @Attribute3 = NULL;                              -- varchar(150)
                                        END;
                                    END;
                                    ---- kondisi jika daily
                                    IF ISNULL(@once, 0) = 0
                                    AND ISNULL(@daily, 0) = 1
                                    BEGIN
                                        SELECT @Isdaily = COUNT(Id)
                                        FROM dbo.Log
                                        WHERE CONVERT(VARCHAR, CreateDate, 101) = CONVERT(VARCHAR, GETDATE(), 101)
                                            AND IdMerchant = @idMerchant
                                            AND IdMember = @idmember
                                            AND Daily = 1;
                                        IF ISNULL(@Isdaily, 0) = 0
                                        BEGIN
                                            ---- kondisi harian dapat
                                            BEGIN TRANSACTION;
                                            UPDATE dbo.Member
                                            SET Point = ISNULL(Point, 0) + @point
                                            WHERE IdMerhant = @idMerchant
                                                AND Id = @idmember;
                                            COMMIT;
                                            EXEC dbo.sp_Log @Guid = @newGuid,          -- uniqueidentifier
                                                            @IdMerchant = @idMerchant, -- bigint
                                                            @IdMember = @idmember,     -- bigint
                                                            @IdEvent = @idevent,       -- bigint
                                                            @Node = @event,            -- varchar(150)
                                                            @Keterangan = 'Sukses !',  -- varchar(250)
                                                            @Point = @point,           -- float
                                                            @Status = 200,             -- int
                                                            @Daily = 1,
                                                            @OnceTime = NULL,
                                                            @Attribute1 = NULL,        -- varchar(150)
                                                            @Attribute2 = NULL,        -- varchar(150)
                                                            @Attribute3 = NULL;        -- varchar(150)
                                        END;
                                        ELSE
                                        BEGIN
                                            EXEC dbo.sp_Log @Guid = @newGuid,                                -- uniqueidentifier
                                                            @IdMerchant = @idMerchant,                       -- bigint
                                                            @IdMember = @idmember,                           -- bigint
                                                            @IdEvent = 0,                                    -- bigint
                                                            @Node = @event,                                  -- varchar(150)
                                                            @Keterangan = 'Event Sudah Didapatkan Member !', -- varchar(250)
                                                            @Point = 0,                                      -- float
                                                            @Status = 400,                                   -- int
                                                            @Daily = NULL,
                                                            @OnceTime = NULL,
                                                            @Attribute1 = NULL,                              -- varchar(150)
                                                            @Attribute2 = NULL,                              -- varchar(150)
                                                            @Attribute3 = NULL;                              -- varchar(150)
                                        END;


                                    END;
                                    ---- kondisi normal tanpa daily dan once time
                                    ELSE IF ISNULL(@daily, 0) = 0
                                            AND ISNULL(@once, 0) = 0
                                    BEGIN
                                        --- update point member jika bukan daily dan Once
                                        BEGIN TRANSACTION;
                                        UPDATE dbo.Member
                                        SET Point = ISNULL(Point, 0) + @point
                                        WHERE IdMerhant = @idMerchant
                                            AND Id = @idmember;
                                        COMMIT;
                                        ---
                                        EXEC dbo.sp_Log @Guid = @newGuid,          -- uniqueidentifier
                                                        @IdMerchant = @idMerchant, -- bigint
                                                        @IdMember = @idmember,     -- bigint
                                                        @IdEvent = @idevent,       -- bigint
                                                        @Node = @event,            -- varchar(150)
                                                        @Keterangan = 'Sukses !',  -- varchar(250)
                                                        @Point = @point,           -- float
                                                        @Status = 200,             -- int
                                                        @Daily = NULL,
                                                        @OnceTime = NULL,
                                                        @Attribute1 = NULL,        -- varchar(150)
                                                        @Attribute2 = NULL,        -- varchar(150)
                                                        @Attribute3 = NULL;        -- varchar(150)
                                    END;
                                    ELSE
                                    BEGIN
                                        --- kondisi event tidak ada
                                        EXEC dbo.sp_Log @Guid = @newGuid,                        -- uniqueidentifier
                                                        @IdMerchant = @idMerchant,               -- bigint
                                                        @IdMember = @idmember,                   -- bigint
                                                        @IdEvent = 0,                            -- bigint
                                                        @Node = @event,                          -- varchar(150)
                                                        @Keterangan = 'Event Tidak Ditemukan !', -- varchar(250)
                                                        @Point = 0,                              -- float
                                                        @Status = 400,                           -- int
                                                        @Daily = NULL,
                                                        @OnceTime = NULL,
                                                        @Attribute1 = NULL,                      -- varchar(150)
                                                        @Attribute2 = NULL,                      -- varchar(150)
                                                        @Attribute3 = NULL;                      -- varchar(150)
                                    END;
                                END;
                            END;
                        END;
                    END;
                END TRY
                BEGIN CATCH
                    --- kondisi event tidak ada
                    EXEC dbo.sp_Log @Guid = @newGuid,                -- uniqueidentifier
                                    @IdMerchant = @idMerchant,       -- bigint
                                    @IdMember = @idmember,           -- bigint
                                    @IdEvent = 0,                    -- bigint
                                    @Node = 'Event',                 -- varchar(150)
                                    @Keterangan = 'Formula Error !', -- varchar(250)
                                    @Point = 0,                      -- float
                                    @Status = 500,                   -- int
                                    @Daily = NULL,
                                    @OnceTime = NULL,
                                    @Attribute1 = NULL,              -- varchar(150)
                                    @Attribute2 = NULL,              -- varchar(150)
                                    @Attribute3 = NULL;              -- varchar(150)
                END CATCH;
                SELECT l.Id,
                    l.CreateDate,
                    l.Guid,
                            -- l.IdMerchant,
                            -- l.IdMember,
                            -- l.IdEvent,
                    l.Node,
                    l.Keterangan,
                    l.Point,
                    l.Status,
                            -- l.Daily,
                            -- l.OnceTime,
                            -- l.Attribute1,
                            -- l.Attribute2,
                            -- l.Attribute3,
                    m.MerchentMemberKey,
                    m.Nama,
                    m.Point MemberPoint,
                    l.Times --,

                --m.Point - @point OldPoint
                FROM dbo.Log l
                    LEFT OUTER JOIN dbo.Member m
                        ON m.Id = l.IdMember
                WHERE l.Guid = @newGuid;
            END;
        ";
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_ExecEvent');
    }
}
