import base64


class Common:

    # /**
    # * IDを指定した桁数まで0埋めして返却します
    # * @param id ID
    # * @param digit 桁数
    # */
    @staticmethod
    def countup_id(id, digit):
        if digit < 0 or digit <= len(id):
            return id

        return id.zfill(digit)

    # /**
    # * 文字列を指定した文字数まで切り捨てて返却します
    # * @param str 文字列
    # * @param num 文字数
    # */
    @staticmethod
    def start_truncate(str, num):
        if len(str) == 0: return 0
        if num < 0 or len(str) <= num: return 0
        return str[num:len(str)]

    # /**
    # * 文字列を指定した文字数以降の文字を切り捨てて返却します
    # * @param str 文字列
    # * @param num 文字数
    # */
    @staticmethod
    def end_truncate(str, num):
        if num < 0 or len(str) <= num:
            return str

        return str[0:num]

    # /**
    # * 文字列を指定した文字数まで空白埋めして返却します
    # * @param str 文字列
    # * @param num 文字数
    # */
    @staticmethod
    def fill(str, num):
        if num < 0 or num <= len(str):
            return str

        return str.zfill(num)

    # /**
    # * 画像からbase64形式にデータを変換して返却します
    # * @param img 画像
    # */
    @staticmethod
    def encode(img):
        return base64.b64encode(img)

    # /**
    # * base64形式から画像にデータを変換して返却します
    # * @param str base64形式
    # */
    @staticmethod
    def decode(str):
        return base64.b64decode(str)

    # /**
    # * 拡張子が画像か判別します
    # * @param mimetype 拡張子
    # */
    @staticmethod
    def isImgMimetype(mimetype):
        extensions = {
            'image/gif': 'gif',
            'image/jpeg': 'jpeg',
            'image/png': 'png',
            'image/bmp': 'bmp'
        }

        if len(extensions[mimetype]) == 0:
            return False

        return True

    # /**
    # * 拡張子を返却します
    # * 画像以外の拡張子の場合はNoneを返します
    # * @param mimetype 拡張子
    # */
    @staticmethod
    def getImgMimetype(mimetype):
        extensions = {
            'image/gif': 'gif',
            'image/jpeg': 'jpeg',
            'image/jpg': 'jpg',
            'image/png': 'png',
            'image/bmp': 'bmp'
        }
        if len(extensions[mimetype]) == 0:
            return None

        return extensions[mimetype]

