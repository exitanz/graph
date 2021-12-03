from ..common.Constant import Constant


# /**
# * 登場人物編集処理の値を保持する
# */
class EditActorRequest:
    errorMsg = []

    # /**
    # * 登場人物編集処理の値を格納します
    # */
    def __init__(self, actorId, actorName, actorInfo, actorImg, opusId, timeId, groupId, userId, version):
        self.actorId = actorId
        self.actorName = actorName
        self.actorInfo = actorInfo
        self.actorImg = actorImg
        self.opusId = opusId
        self.timeId = timeId
        self.groupId = groupId
        self.userId = userId
        self.version = version

    def getActorId(self):
        return self.actorId

    def getActorName(self):
        return self.actorName

    def getActorInfo(self):
        return self.actorInfo

    def getActorImg(self):
        return self.actorImg

    def getOpusId(self):
        return self.opusId

    def getTimeId(self):
        return self.timeId

    def getGroupId(self):
        return self.groupId

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
            if (len(self.userId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザ名の文字数チェック
            if (100 < len(self.userName)):
                self.errorMsg.append('エラー ：ユーザ名は100文字以内で入力してください')
                validationFlg = True

            # パスワードの文字数チェック
            if (20 < len(self.password)):
                self.errorMsg.append('エラー ：パスワードは20文字以内で入力してください')
                validationFlg = True            

        except Exception as e:
            validationFlg = True

        return validationFlg
