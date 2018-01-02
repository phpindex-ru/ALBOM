<?php
/**
 * @param string $aInitialImageFilePath - ��ப�, �।�⠢����� ���� � ��१������ ����ࠦ����
 * @param string $aNewImageFilePath - ��ப�, �।�⠢����� ���� �㤠 ��� ��࠭��� ��室��� ��१����� ����ࠦ����
 * @param int $aNewImageWidth - �ਭ� ��室���� ��१������ ����ࠦ����
 * @param int $aNewImageHeight - ���� ��室���� ��१������ ����ࠦ����
 */
function cropImage($aInitialImageFilePath, $aNewImageFilePath, $aNewImageWidth, $aNewImageHeight) {
    if (($aNewImageWidth < 0) || ($aNewImageHeight < 0)) {
        return false;
    }

    // ���ᨢ � �����ন����묨 ⨯��� ����ࠦ����
    $lAllowedExtensions = array(1 => "gif", 2 => "jpeg", 3 => "png"); 
    
    // ����砥� ࠧ���� � ⨯ ����ࠦ���� � ���� �᫠
    list($lInitialImageWidth, $lInitialImageHeight, $lImageExtensionId) = getimagesize($aInitialImageFilePath); 
    
    if (!array_key_exists($lImageExtensionId, $lAllowedExtensions)) {
        return false;
    }
    $lImageExtension = $lAllowedExtensions[$lImageExtensionId];
    
    // ����砥� �������� �㭪樨, ᮮ⢥�������� ⨯�, ��� ᮧ����� ����ࠦ����
    $func = 'imagecreatefrom' . $lImageExtension; 
    // ������ ���ਯ�� ��室���� ����ࠦ����
    $lInitialImageDescriptor = $func($aInitialImageFilePath);

    // ��।��塞 �⮡ࠦ����� �������
    $lCroppedImageWidth = 0;
    $lCroppedImageHeight = 0;
    $lInitialImageCroppingX = 0;
    $lInitialImageCroppingY = 0;
    if ($aNewImageWidth / $aNewImageHeight > $lInitialImageWidth / $lInitialImageHeight) {
        $lCroppedImageWidth = floor($lInitialImageWidth);
        $lCroppedImageHeight = floor($lInitialImageWidth * $aNewImageHeight / $aNewImageWidth);
        $lInitialImageCroppingY = floor(($lInitialImageHeight - $lCroppedImageHeight) / 2);
    } else {
        $lCroppedImageWidth = floor($lInitialImageHeight * $aNewImageWidth / $aNewImageHeight);
        $lCroppedImageHeight = floor($lInitialImageHeight);
        $lInitialImageCroppingX = floor(($lInitialImageWidth - $lCroppedImageWidth) / 2);
    }
    
    // ������ ���ਯ�� ��� ��室���� ����ࠦ����
    $lNewImageDescriptor = imagecreatetruecolor($aNewImageWidth, $aNewImageHeight);
    imagecopyresampled($lNewImageDescriptor, $lInitialImageDescriptor, 0, 0, $lInitialImageCroppingX, $lInitialImageCroppingY, $aNewImageWidth, $aNewImageHeight, $lCroppedImageWidth, $lCroppedImageHeight);
    $func = 'image' . $lImageExtension;
    
    // ��࠭塞 ����祭��� ����ࠦ���� � 㪠����� 䠩�
    return $func($lNewImageDescriptor, $aNewImageFilePath);
}
