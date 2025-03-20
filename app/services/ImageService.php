<?php

namespace Services;

use Exception;

class ImageService
{
	/**
	 * If imageName is set, it will remove the image with that name
	 * Then it will upload the new image and return the new file name
	 * 
	 * @param array $file The file array.
	 * @param mixed $imageName The name of the image to be removed.
	 * @return string The new file name.
	 * @throws Exception If the file array is invalid, the file type is invalid, the file size exceeds the maximum file size limit, the file is not an actual uploaded file, the upload directory cannot be created, the file cannot be saved, or the image cannot be deleted.
	 */
	public function uploadImage(array $file, ?string $imageName = null): string
	{
		// Ensure the file array contains necessary keys
		if (!isset($file['name'], $file['tmp_name'], $file['size'])) {
			throw new Exception('Invalid file array.', 400);
		}

		// Ensure upload directory exists
		$uploadDir = __DIR__ . '/../Public/images/uploaded/';

		if (!is_dir($uploadDir)) {
			if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
				throw new Exception('Failed to create upload directory.', 500);
			}
		}

		// Validate file type
		$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
		$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

		if (!in_array($fileExtension, $allowedExtensions)) {
			throw new Exception('Invalid file type.', 400);
		}

		// Validate file size
		$this->checkFileSize($file, 5);

		// Ensure the file is an actual uploaded file
		if (!is_uploaded_file($file['tmp_name'])) {
			throw new Exception('Potential file upload attack.', 400);
		}

		// Generate a unique filename
		$newFileName = 'Image_' . time() . '.' . $fileExtension;
		$uploadPath = $uploadDir . $newFileName;

		if (isset($imageName)) {
			// Remove old image
			$this->removeImage($imageName);
		}

		// Move file to the correct directory
		if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
			throw new Exception('Failed to save file.', 500);
		}

		return $newFileName;
	}

	/**
	 * Removes the image with the specified name.
	 *
	 * @param string $imageName The name of the image to be removed.
	 * @throws Exception If the image cannot be deleted.
	 */
	public function removeImage(string $imageName): void
	{
		$uploadDir = __DIR__ . '/../Public/images/uploaded/';
		$uploadPath = $uploadDir . $imageName;

		if (file_exists($uploadPath)) {
			if (!unlink($uploadPath)) {
				throw new Exception('Failed to delete image.', 500);
			}
		}
	}

	/**
	 * Checks if the file size exceeds the maximum file size limit.
	 *
	 * @param array $file The file array.
	 * @param int $maxSize The maximum file size in MB.
	 * @throws Exception If the file size exceeds the maximum file size limit.
	 */
	public function checkFileSize(array $file, int $maxSize = 5): void
	{
		$maxFileSizeCalculated = $maxSize * 1024 * 1024;
		if ($file['size'] > $maxFileSizeCalculated) {
			throw new Exception('File size exceeds the maximum limit.', 400);
		}
	}
}