from ..common.Constant import Constant


# /**
# * グループ編集処理の値を保持する
# */
class EditGroupRequest:
    errorMsg = []

    # /**
    # * グループ編集処理の値を格納します
    # */
    def __init__(self, groupId, groupName, groupInfo, groupColor, userId, version):
        self.groupId = groupId
        self.groupName = groupName
        self.groupInfo = groupInfo
        self.groupColor = groupColor
        self.userId = userId
        self.version = version

    def getGroupId(self):
        return self.groupId

    def getGroupName(self):
        return self.groupName

    def getGroupInfo(self):
        return self.groupInfo

    def getGroupColor(self):
        return self.groupColor

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
            if (len(self.groupId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # グループIDの文字数チェック
            if (Constant.GROUP_ID_DIGIT + len(Constant.GROUP_ID_STR) < len(self.groupId)):
                self.errorMsg.append(
                    'エラー ：グループIDは' + Constant.GROUP_ID_DIGIT + len(Constant.GROUP_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # グループ名の文字数チェック
            if (len(self.groupName) != 0 and 100 < len(self.groupName)):
                self.errorMsg.append('エラー ：グループ名は100文字以内で入力してください')
                validationFlg = True

            # グループ詳細の文字数チェック
            if (len(self.groupInfo) != 0 and 1200 < len(self.groupInfo)):
                self.errorMsg.append('エラー ：グループ詳細は1200文字以内で入力してください')
                validationFlg = True

            # グループ色の文字数チェック
            if (len(self.groupColor) != 0 and 100 < len(self.groupColor)):
                self.errorMsg.append('エラー ：グループ色は100文字以内で入力してください')
                validationFlg = True          

        except Exception as e:
            validationFlg = True

        return validationFlg
