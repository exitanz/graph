from ..common.Constant import Constant


# /**
# * 作品編集処理の値を保持する
# */
class EditOpusRequest:
    errorMsg = []

    # /**
    # * 作品編集処理の値を格納します
    # */
    def __init__(self, opusId, opusName, opusFlg, userId, version):
        self.opusId = opusId
        self.opusName = opusName
        self.opusFlg = opusFlg
        self.userId = userId
        self.version = version

    def getOpusId(self):
        return self.opusId

    def getOpusName(self):
        return self.opusName

    def getOpusFlg(self):
        return self.opusFlg

    def getUserId(self):
        return self.userId

    def getVersion(self):
        return self.version

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.opusId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 作品IDの文字数チェック
            if (Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) < len(self.opusId)):
                self.errorMsg.append(
                    'エラー ：作品IDは' + Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # 作品名の文字数チェック
            if (100 < len(self.opusName)):
                self.errorMsg.append('エラー ：作品名は100文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
